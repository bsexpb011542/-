import os
import torch
import torch.nn as nn
import torch.optim as optim
from torch.utils.data import DataLoader
from torchvision import datasets, transforms
from torchvision.utils import save_image
import numpy as np

# 設定資料集和產出圖
input_dir = 'C:/Users/s10350112/Desktop/DS'
output_dir = 'C:/Users/s10350112/AppData/Local/anaconda3/envs/gpu12.0/workspace/DDS'
if not os.path.exists(output_dir):
    os.makedirs(output_dir)

# 確認是否使用CUDA
device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
print(f"Using device: {device}")

# 生成器模型
class Generator(nn.Module):
    def __init__(self, z_dim):
        super(Generator, self).__init__()
        self.gen = nn.Sequential(
            nn.Linear(z_dim, 128),
            nn.ReLU(),
            nn.Linear(128, 256),
            nn.ReLU(),
            nn.Linear(256, 512),
            nn.ReLU(),
            nn.Linear(512, 1024),
            nn.ReLU(),
            nn.Linear(1024, 3*128*128),  
            nn.Tanh()  # 輸出的數值範圍在 [-1, 1] 之間
        )

    def forward(self, z):
        return self.gen(z).view(-1, 3, 128, 128) 
    
class Discriminator(nn.Module):
    def __init__(self):
        super(Discriminator, self).__init__()
        self.disc = nn.Sequential(
            nn.Linear(3*128*128, 512),  
            nn.LeakyReLU(0.2),
            nn.Linear(512, 256),
            nn.LeakyReLU(0.2),
            nn.Linear(256, 1),
        )

    def forward(self, img):
        return self.disc(img.view(-1, 3*128*128))

# WGAN-GP 的 Gradient Penalty 函數
def gradient_penalty(critic, real, fake, device):
    batch_size, C, H, W = real.shape
    epsilon = torch.rand((batch_size, 1, 1, 1), device=device).repeat(1, C, H, W)
    interpolated_images = real * epsilon + fake * (1 - epsilon)

    mixed_scores = critic(interpolated_images)
    gradient = torch.autograd.grad(
        inputs=interpolated_images,
        outputs=mixed_scores,
        grad_outputs=torch.ones_like(mixed_scores),
        create_graph=True,
        retain_graph=True,
    )[0]
    gradient = gradient.view(gradient.size(0), -1)
    gradient_norm = gradient.norm(2, dim=1)
    gp = torch.mean((gradient_norm - 1) ** 2)
    return gp

# 訓練參數
device = "cuda" if torch.cuda.is_available() else "cpu"
z_dim = 100
lr = 1e-4
batch_size = 32
num_epochs = 30001

# 建立生成器和判別器
gen = Generator(z_dim).to(device)
disc = Discriminator().to(device)
opt_gen = optim.Adam(gen.parameters(), lr=lr, betas=(0.5, 0.999))
opt_disc = optim.Adam(disc.parameters(), lr=lr, betas=(0.5, 0.999))

# 資料處理
transform = transforms.Compose([
    transforms.Resize((128, 128)),
    transforms.ToTensor(),
    transforms.Normalize([0.5 for _ in range(3)], [0.5 for _ in range(3)])
])

dataset = datasets.ImageFolder(root=input_dir, transform=transform)
loader = DataLoader(dataset, batch_size=batch_size, shuffle=True)

# 訓練模型
for epoch in range(num_epochs):
    for real, _ in loader:
        real = real.to(device)
        batch_size = real.shape[0]

        # 訓練判別器
        for _ in range(5):
            z = torch.randn(batch_size, z_dim).to(device)
            fake = gen(z)
            disc_real = disc(real).reshape(-1)
            disc_fake = disc(fake).reshape(-1)
            gp = gradient_penalty(disc, real, fake, device)
            loss_disc = -(torch.mean(disc_real) - torch.mean(disc_fake)) + 10 * gp

            opt_disc.zero_grad()
            loss_disc.backward()
            opt_disc.step()

        # 訓練生成器
        z = torch.randn(batch_size, z_dim).to(device)
        fake = gen(z)
        loss_gen = -torch.mean(disc(fake))

        opt_gen.zero_grad()
        loss_gen.backward()
        opt_gen.step()

    #顯示epoch loss函數
    print(f"Epoch {epoch}/{num_epochs} Loss D: {loss_disc:.4f}, Loss G: {loss_gen:.4f}")

    # 每100個epoch儲存生成的圖片
    if epoch % 100 == 0:
        print(f"--save {epoch}/{num_epochs} img ")
        fake_images = gen(torch.randn(batch_size, z_dim).to(device))
        save_image(fake_images, os.path.join(output_dir, f"gen_img_{epoch}.png"), normalize=True)
