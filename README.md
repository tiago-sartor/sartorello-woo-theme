# Sartorello® Woo Theme 🌟

[![WordPress Version](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg?style=flat-square&logo=wordpress)](https://wordpress.org)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-777BB4.svg?style=flat-square&logo=php)](https://php.net)
[![Alpine.js Version](https://img.shields.io/badge/Alpine.js-v3.15%2B-8BC0D0.svg?style=flat-square&logo=alpine.js)](https://alpinejs.dev)
[![Tailwind CSS Version](https://img.shields.io/badge/Tailwind_CSS-v4.3.0-38B2AC.svg?style=flat-square&logo=tailwind-css)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-GPL--3.0-green.svg?style=flat-square)](https://www.gnu.org/licenses/gpl-3.0.html)

A highly bespoke, premium e-commerce WordPress theme custom-tailored for the renowned Brazilian furniture manufacturer **Sartorello® Móveis**. Engineered from the ground up to combine speed, high-end aesthetics, and zero plugin bloat, this theme utilizes a cutting-edge front-end stack featuring **Alpine.js v3**, **Tailwind CSS v4**, and a lightweight **Webpack** asset pipeline.

By disabling default WooCommerce styles, this theme gives full visual control directly to custom-designed, utility-driven layouts optimized for luxury interiors.

---

## ✨ Key Features

- **💡 Proprietary Slider & Gallery Mechanics**:
  - The product page image gallery, promotional banner carousels, and sliders were built **entirely from scratch without relying on external slider libraries** (such as Swiper or Slick).
  - Designed leveraging **Alpine.js** for reactive component state management and lightweight **Vanilla JS** to drive physics, touch gestures, and desktop mouse-drag scrolling.
  - Implements a bespoke drag-and-swipe controller with fine-tuned horizontal gesture locking, dynamic inertia, dynamic viewport calculations, and seamless CSS scroll snapping.
- **⚡ Modern Front-End Stack**: Powered by **Tailwind CSS v4** (utilizing the CSS-first CLI compiler) and **Alpine.js v3** (integrated with *Collapse*, *Intersect*, and *Resize* plugins) for premium, fluid user micro-interactions.
- **🛠️ Dedicated Theme Options Panel**:
  - Direct dashboard controls to configure brand identity assets (logos, custom home banners, and motto text).
  - Built-in business settings: E-mail, click-to-chat WhatsApp integration (using custom digit-only server-side sanitization), social media networks, and custom rich-text footer settings.
- **🇧🇷 Brazilian E-Commerce Optimizations**:
  - Native CEP-based address autocomplete integrated natively on checkout.
  - Intelligent Individual vs Corporate (PF/PJ) fields visibility toggles for frictionless legal verification.
- **🚀 Engineered for Performance**: 
  - Minimalist file sizes and zero standard WooCommerce CSS payloads.
  - Granular, context-aware enqueue scripts (address autocomplete, gallery, and mini-cart scripts only load on target pages to keep the store's PageSpeed rating at 100).

---

## 📁 Repository Structure

```
sartorello-woo-theme/
├── assets/                  # Compiled production stylesheets & script bundles
├── includes/                # Theme-specific core classes & settings panel
│   └── theme-settings.php   # Custom Sartorello® dashboard integration code
├── src/                     # Modern front-end source files
│   ├── index.js             # Alpine JS entry-point registering custom modules
│   ├── input.css            # Tailwind CSS source compiling design tokens
│   └── modules/             # Pure Vanilla JS modules (carousel-slider, cart, search, countdown)
├── woocommerce/             # Highly customized overrides for WooCommerce templates
│   └── single-product/
│       └── product-image-gallery.php   # The custom-built gallery component
├── functions.php            # Core theme configuration, custom menus, and filters
├── webpack.config.js        # Webpack bundle compilation rules
├── package.json             # Build toolchain dependency settings
└── style.css                # Required WordPress stylesheet with theme metadata
```

---

## ⚙️ Minimum Requirements

- **PHP** >= 8.1
- **WordPress** >= 6.0
- **Node.js** >= 18 (required for compiled builds during local development)

---

## 📄 License & Credits

- **License**: Licensed under the GNU General Public License v3 or later ([GPL-3.0-or-later](https://www.gnu.org/licenses/gpl-3.0.html)).
- **Created by**: [Tiago Sartor](https://github.com/tiago-123) for **Sartorello® Móveis**.

---
