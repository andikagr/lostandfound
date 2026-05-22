import sys
import os
from PIL import Image

input_file = sys.argv[1]
output_file = sys.argv[2]
bg_color_hex = sys.argv[3] # e.g. '#e31837'

img = Image.open(input_file).convert("RGBA")
width, height = img.size
pixels = img.load()

# Sample background from top-left pixel
bg_r, bg_g, bg_b, _ = pixels[0, 0]

for y in range(height):
    for x in range(width):
        r, g, b, a = pixels[x, y]
        
        # We assume foreground is WHITE (255,255,255)
        # alpha is based on how far the pixel is from bg color towards white
        # Green channel diff is usually a good indicator if bg is red
        bg_val = bg_g
        fg_val = 255
        pixel_val = g
        
        if fg_val > bg_val:
            alpha = int((max(0, pixel_val - bg_val) / (fg_val - bg_val)) * 255)
        else:
            alpha = 255
            
        alpha = max(0, min(255, alpha))
        
        # Set to pure white with computed alpha
        pixels[x, y] = (255, 255, 255, alpha)

# Find bounding box of non-transparent pixels to crop it tightly
bbox = img.getbbox()
if bbox:
    img = img.crop(bbox)

img.save(output_file, "PNG")
print(f"Successfully extracted logo to {output_file}")
