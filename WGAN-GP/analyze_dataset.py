
import os
import cv2
import numpy as np
import matplotlib.pyplot as plt
from PIL import Image
from collections import Counter
from sklearn.manifold import TSNE
from sklearn.cluster import KMeans
from torchvision import models, transforms
import torch
import pandas as pd

# 資料夾路徑（修改成你的資料集路徑）
image_folder = "C:/Users/s10350112/Desktop/DS/DU"  # TODO: 修改為你的資料夾路徑

# 初始化模型與轉換器
resnet_model = models.resnet18(pretrained=True)
resnet_model = torch.nn.Sequential(*list(resnet_model.children())[:-1])
resnet_model.eval()

transform = transforms.Compose([
    transforms.Resize((224, 224)),
    transforms.ToTensor()
])

features = []
file_names = []
image_data = []
gray_means = []

for fname in os.listdir(image_folder):
    if fname.lower().endswith(('.jpg', '.png', '.jpeg')):
        file_path = os.path.join(image_folder, fname)
        try:
            with Image.open(file_path) as img:
                size = img.size
                mode = img.mode
        except:
            continue

        img_gray = cv2.imread(file_path, cv2.IMREAD_GRAYSCALE)
        if img_gray is None:
            continue
        mean_gray = np.mean(img_gray)
        gray_means.append(mean_gray)

        img_rgb = Image.open(file_path).convert('RGB')
        input_tensor = transform(img_rgb).unsqueeze(0)
        with torch.no_grad():
            feat = resnet_model(input_tensor).squeeze().numpy()
        features.append(feat)
        file_names.append(fname)

        image_data.append({
            "檔名": fname,
            "尺寸": f"{size[0]}x{size[1]}",
            "模式": mode,
            "平均亮度": round(mean_gray, 2)
        })

df = pd.DataFrame(image_data)

# 畫亮度分布圖
plt.figure()
plt.hist(gray_means, bins=30, color='gray')
plt.title("Image Brightness Distribution")
plt.xlabel("Average Gray Value")
plt.ylabel("Number of Images")
plt.grid(True)
plt.savefig("brightness_histogram.png")

# t-SNE + 聚類
tsne = TSNE(n_components=2, random_state=42)
reduced = tsne.fit_transform(features)

kmeans = KMeans(n_clusters=3, random_state=42).fit(features)
df['群組'] = kmeans.labels_

# 畫 t-SNE 群組圖
plt.figure()
for i in range(3):
    plt.scatter(reduced[kmeans.labels_ == i, 0], reduced[kmeans.labels_ == i, 1], label=f"group {i}", alpha=0.6)
plt.title("t-SNE Visualization with KMeans Clustering")
plt.xlabel("Dimension 1")
plt.ylabel("Dimension 2")
plt.legend()
plt.grid(True)
plt.savefig("tsne_kmeans.png")

# 匯出分析報表
df.to_csv("dataset_feature_report.csv", index=False)
print("分析完成！請查看下列檔案：")
print("- brightness_histogram.png")
print("- tsne_kmeans.png")
print("- dataset_feature_report.csv")
