<p align="center">
  <a href="https://github.com/imran" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="320" alt="Infulab Logo">
  </a>
</p>

<h1 align="center">Infulab — Next-Generation Influencer Marketing & Creator Marketplace</h1>

<p align="center">
  <strong>A premium, escrow-protected freelance marketplace connecting top brands, agencies, and verified content creators across Instagram, TikTok, YouTube, and UGC.</strong>
</p>

<p align="center">
  <a href="#-key-features"><img src="https://img.shields.io/badge/Laravel-9.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 9"></a>
  <a href="#-technology-stack"><img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.1+"></a>
  <a href="#-escrow--financial-security"><img src="https://img.shields.io/badge/Escrow-100%25%20Protected-00b894?style=for-the-badge&logo=shield&logoColor=white" alt="Escrow Protected"></a>
  <a href="#-payment-gateways--settlements"><img src="https://img.shields.io/badge/Gateways-20%2B%20Supported-0984e3?style=for-the-badge&logo=stripe&logoColor=white" alt="20+ Gateways"></a>
  <a href="#-license"><img src="https://img.shields.io/badge/License-MIT-6c5ce7?style=for-the-badge" alt="MIT License"></a>
</p>

---

## 📖 Executive Summary

**Infulab** is an enterprise-grade digital marketplace platform specifically engineered for the creator economy. It bridges the gap between commercial brands seeking targeted influencer marketing campaigns and verified content creators offering bespoke promotional services, sponsored content, and UGC (User Generated Content) media assets.

Built with a bulletproof **Escrow Transaction Architecture**, Infulab protects both parties: brand budgets remain securely locked in escrow until milestone deliverables are submitted, reviewed, and approved, guaranteeing creators are compensated upon work completion without payment default risks.

---

## 🌟 Newly Added Features & Enhancements

In the latest release, Infulab has been upgraded with modern creator tools and a state-of-the-art visual design:

### 1. 🤖 AI Campaign Brief & Proposal Generator (`/campaign-brief-generator`)
- **Interactive Brief Builder**: Brands and marketing agencies can draft standardized, high-converting influencer briefs in under two minutes.
- **Structured Campaign Fields**: Specify campaign objectives (Brand Awareness, Product Launch, Direct Conversions, UGC Ad Rights), platform selections, creator tier requirements, and turnaround schedules.
- **Deliverable Checklist**: Multi-select deliverables including Instagram Reels, TikTok Videos, Story Slides with sticker links, YouTube integrations, and Link in Bio slots.
- **FTC & Compliance Guidelines**: Pre-populates disclosure requirements (`#ad`, `#sponsored`), brand tagging guidelines, and exclusivity parameters.
- **1-Click Export**: Instant formatted Markdown and Plaintext generation with one-click clipboard copy and `.md` file download.

### 2. 📊 Influencer Rate & ROI Calculator (`/roi-calculator`)
- **Real-Time CPM & CPE Pricing Algorithm**: Real-time pricing benchmarks across Instagram, TikTok, YouTube, and UGC.
- **Interactive Sliders**: Adjust follower audience size (Nano, Micro, Mid-tier, Macro) and engagement rates (0.5% to 15.0%).
- **Projected Performance Modeling**: Accurately estimates impressions, engagements, link clicks, orders, and projected gross revenue.
- **Fair Market Rate Benchmark**: Displays fair creator fee ranges so brands don’t overpay and influencers know exactly what to charge.
- **Return on Investment (ROI) Multiplier**: Calculates estimated campaign ROAS (e.g., 2.4x, 3.8x).

### 3. 🛡️ Infulab Escrow Guarantee & Trust Hub
- **4-Stage Milestone Transparency**: Visual milestone workflow explaining Buyer Protection and Guaranteed Creator Payouts.
- **Milestone 1**: Secure Escrow Deposit — Funds deposited by client are held in Infulab vault.
- **Milestone 2**: Content Production & Draft Review — Creator prepares content according to brief.
- **Milestone 3**: Live Publication & Metric Verification — Client verifies proof of performance.
- **Milestone 4**: Instant Automatic Release — Escrow unlocks earnings directly to creator's balance.

### 4. 🎨 Modern Glassmorphic UI & Visual Experience
- **Modern Typography System**: Powered by Google Fonts `Outfit` (bold high-contrast headings) and `Plus Jakarta Sans` (refined readable UI copy).
- **Glassmorphism Header**: Sticky frosted-glass navbar (`backdrop-filter: blur(20px)`) with glowing active navigation indicators and mobile drawer.
- **Enhanced Hero Banner**: High-impact gradient typography, floating trust badges (`4.9/5 Rating`, `100% Escrow Protection`), modern pill search bar, and social platform filter chips (Instagram, TikTok, YouTube, UGC).
- **Elevated Creator & Service Cards**: Verified checkmark badges, online pulse indicators, social follower tags, image zoom transitions, and interactive heart/favorite micro-animations.

---

## 🚀 Complete Platform Feature Matrix

### 👤 Brand & Client Capabilities
- **Multi-Criteria Creator Discovery**: Search and filter influencers by category, niche, country, rating stars, and completed order volume.
- **Direct Service Gigs & Custom Hiring**:
  - Purchase pre-packaged gigs (e.g., "1x Dedicated 60s Reel with swipe-up").
  - Submit bespoke hiring proposals tailored with custom deadlines and budgets.
- **Secure Escrow Funding**: Deposit via 20+ automated gateways (Stripe, PayPal, Razorpay, etc.) or manual bank transfer.
- **In-App Realtime Collaboration**:
  - Chat channels with creators for order deliverables and hiring requests.
  - File attachments for media assets, scripts, and contract agreements.
- **Milestone Approval & Dispute Mediation**: Approve completed work to release escrow, or request revisions/file a dispute if deliverables do not match brief specs.
- **Verified Reviews & Ratings**: Submit star ratings and written testimonials after order completion.

### 🌟 Influencer & Content Creator Capabilities
- **Custom Service / Gig Studio**: Create unlimited service packages with image galleries, pricing, delivery turnaround, tags, and category associations.
- **Interactive Profile & Media Kit**: Showcase follower reach across social channels, biography, education, certifications, and portfolio items.
- **Direct Proposal Management**: Accept, reject, or negotiate custom client hiring requests.
- **Job Status Pipeline**: Track campaigns across `Pending`, `In Progress`, `Job Done / Draft Review`, `Completed`, `Reported`, and `Cancelled`.
- **Earning Withdrawals**: Request payouts via automated or manual withdrawal methods (Bank Transfer, PayPal, Crypto, etc.) with transparent fee calculations.
- **KYC Identity Verification**: Submit legal verification documents to unlock tier withdrawals and display verified badges.
- **Google Authenticator (2FA)**: Two-factor authentication for maximum account security.

### 🛡️ Admin & Operational Controls
- **Comprehensive Control Dashboard**: Real-time telemetry on revenue, escrow volumes, pending services, dispute cases, and user registrations.
- **User & Influencer Moderation**: KYC approval engine, account banning/unbanning, balance adjustments, and activity logs.
- **Service & Order Supervision**: Review and approve new gigs, moderate reported orders, and arbitrate dispute resolutions.
- **Payment Gateway Architecture**:
  - 20+ Automated payment gateways pre-integrated.
  - Unlimited manual gateways with customizable form fields.
  - Currency conversion rules and deposit charge settings.
- **Withdrawal Management**: Set withdrawal minimum/maximum limits, processing fees, and approve/reject payouts.
- **Automated Communication Engine**: Email templates, SMS gateways (Twilio, Nexmo, Infobip), and push notification dispatcher.
- **CMS & Page Builder**: Manage SEO meta tags, cookie consent policy, blog posts, FAQs, and template sections dynamically from the admin panel.

---

## 🛠️ Technology Stack

| Layer | Technology | Description |
| :--- | :--- | :--- |
| **Backend Core** | PHP 8.1+ & Laravel 9.x | Robust MVC architecture with Eloquent ORM |
| **Database** | MySQL 5.7+ / MariaDB 10.3+ | Relational schema with foreign keys and indexing |
| **Frontend Templates** | Blade Templating Engine | Server-side rendered responsive views |
| **Styles & UI** | Vanilla CSS3, CSS Variables, Bootstrap 5 | Modern glassmorphism, responsive grid, micro-interactions |
| **Typography** | Google Fonts (`Outfit` & `Plus Jakarta Sans`) | Modern typography tokens |
| **Icons** | LineAwesome & FontAwesome 5 | High-resolution SVG vector iconography |
| **Security** | Laravel Encrypter, 2FA Google Auth, CSRF, XSS | Bank-grade security practices |

---

## 📂 Project Architecture

```
infu/
├── assets/                           # Public static asset directory
│   ├── global/                       # Shared libraries (Bootstrap, LineAwesome, jQuery)
│   ├── images/                       # Uploaded logos, banners, and frontend assets
│   └── templates/basic/              # Basic template stylesheet, scripts, and media
│       └── css/modern-premium.css    # Modern UI design system
├── core/                             # Primary Laravel Application root
│   ├── app/
│   │   ├── Http/Controllers/        # SiteController, Admin, Influencer, User controllers
│   │   ├── Models/                   # 44+ Eloquent models (Influencer, Order, Service, Escrow...)
│   │   ├── Notify/                   # Email, SMS, and Push notification dispatchers
│   │   └── Providers/                # Service providers and global view share bindings
│   ├── config/                       # Application, database, mail, and gateway configurations
│   ├── database/migrations/          # Database migrations & seeders
│   ├── resources/
│   │   └── views/templates/basic/    # Modern Blade templates
│   │       ├── campaign_brief.blade.php   # AI Campaign Brief Generator
│   │       ├── roi_calculator.blade.php   # Influencer Rate & ROI Calculator
│   │       ├── home.blade.php             # Homepage layout
│   │       ├── sections/                  # Banner, Escrow Trust, Top Creators, Services
│   │       └── partials/modern_css.blade.php # Global modern design system
│   ├── routes/
│   │   ├── web.php                   # Frontend, campaign tools, and public routes
│   │   ├── influencer.php            # Influencer portal routes
│   │   ├── user.php                  # Client / brand portal routes
│   │   └── admin.php                 # Administrative back-office routes
│   └── .env.example                  # Environment configuration template
├── index.php                         # Application entrypoint
└── .htaccess                         # Apache routing & SSL redirect rules
```

---

## ⚡ Installation & Deployment Guide

### Prerequisites
- **PHP**: 8.1 or higher
- **PHP Extensions**: `BCMath`, `Ctype`, `Fileinfo`, `JSON`, `Mbstring`, `OpenSSL`, `PDO`, `PDO_MySQL`, `Tokenizer`, `XML`, `cURL`, `GD`
- **Database**: MySQL 5.7+ / MariaDB 10.3+
- **Composer**: 2.x
- **Web Server**: Apache / Nginx / LiteSpeed

### Step 1: Clone the Repository
```bash
git clone https://github.com/your-username/infu.git
cd infu/core
```

### Step 2: Install Composer Dependencies
```bash
composer install --optimize-autoloader --no-dev
```

### Step 3: Configure Environment
Copy the example environment configuration file and update your database credentials:
```bash
cp .env.example .env
```
Open `.env` and set:
```env
APP_NAME="Infulab"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### Step 4: Generate Encryption Key & Run Migrations
```bash
php artisan key:generate
php artisan migrate --seed
```

### Step 5: Configure Storage Symlink
```bash
php artisan storage:link
```

### Step 6: Configure Background Cron Jobs
Set up a standard UNIX cron job to trigger every minute:
```bash
* * * * * cd /path-to-your-project/core && php artisan schedule:run >> /dev/null 2>&1
```

---

## 💳 Integrated Payment Gateways

Infulab ships with out-of-the-box support for over 20 global payment processors:
- **Global / Card**: Stripe, PayPal, Authorize.net
- **European**: Mollie, Skrill, Sofort, SEPA
- **African**: Paystack, Flutterwave
- **Asian**: Razorpay, Paytm, Cashfree
- **Cryptocurrency**: CoinGate, CoinPayments, BTCPay Server, Binance Pay
- **Custom / Manual**: Bank Wire, Local Over-the-Counter, Mobile Money

---

## 🔒 Security & Compliance

- **Escrow Vault Mechanism**: Client payments are authorized and held until job milestones are fulfilled.
- **Two-Factor Authentication (2FA)**: Time-based One-Time Passwords (TOTP) supported via Google Authenticator.
- **KYC & Identity Verification**: Upload government-issued IDs to verify creator credibility before payout releases.
- **Protection Measures**: Comprehensive CSRF protection, PDO prepared statements, rate limiting, and input sanitization against XSS.

---

## 🤝 Contributing

Contributions are welcome! If you find a bug or have a suggestion:
1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the **MIT License**. See the `LICENSE` file for details.

---

## 🤝 Let's Build Something Exceptional

I'm actively open to: **Remote Senior Full-Stack Roles** · **Freelance Contracts** · **Technical Partnerships** · **Long-Term Collaborations** in **Laravel · WordPress · React/Next.js · AI-powered Platforms · Security Audits · SaaS Architecture**

- 📍 **Timezone:** UTC+6 (Dhaka/Rangpur) — flexible overlap for US, EU & Asia
- ⚡ **Available:** Immediately · Production-first · Fast delivery · Transparent communication

| Platform | Link |
| :--- | :--- |
| 🌐 **Portfolio** | [imrandev.bd](https://imrandev.bd/) |
| 💼 **LinkedIn** | [linkedin.com/in/imranbru99](https://www.linkedin.com/in/imranbru99/) |
| 🐙 **GitHub** | [github.com/imranbru99](https://github.com/imranbru99) |
| 🐦 **X / Twitter** | [@imrandev_bd](https://x.com/imrandev_bd) |
| 📺 **YouTube** | [@ImranDevBD](https://www.youtube.com/@ImranDevBD) |
| 📸 **Instagram** | [@imranbru99](https://www.instagram.com/imranbru99/) |
| 📘 **Facebook** | [ExpertImranDev](https://www.facebook.com/ExpertImranDev/) |
| 🎵 **TikTok** | [@imrandev_bd](https://www.tiktok.com/@imrandev_bd) |
| 🧵 **Threads** | [@imranbru99](https://www.threads.com/@imranbru99) |
| 📌 **Pinterest** | [@imrandev_bd](https://www.pinterest.com/imrandev_bd/) |
| 💬 **WhatsApp** | [+880 1576-918420](http://wa.me/+8801576918420) |
| 📧 **Email** | [me@imrandev.bd](mailto:me@imrandev.bd) |
| 🔗 **All Links** | [linktr.ee/ExpertImranDev](https://linktr.ee/ExpertImranDev) |

> *"Security isn't an add-on — it's the foundation. Scale, speed, and trust drive every line of code I write."*  
> — **Imran Ahmed**

<p align="center">
  Crafted with ❤️ for the Global Creator Economy.
</p>

