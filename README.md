# Blog System 📝

A full-featured blog system with Markdown editor, comment moderation, and comprehensive content management built with Laravel 12.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![Markdown](https://img.shields.io/badge/Markdown-Editor-green)

## 🚀 Features

### Content Management
- ✅ **Rich Markdown Editor** - SimpleMDE with live preview and formatting toolbar
- ✅ **Post Management** - Create, read, update, delete blog posts
- ✅ **Draft System** - Save posts as drafts before publishing
- ✅ **SEO-Friendly Slugs** - Auto-generated URL-friendly slugs
- ✅ **Featured Images** - Upload and manage post images
- ✅ **Excerpts** - Optional post summaries for listings

### Organization
- 🏷️ **Categories** - Organize posts with color-coded categories
- 🔖 **Tags** - Multiple tags per post for better discoverability
- 🔍 **Search Functionality** - Search posts by title, content, or excerpt
- 📊 **Filtering** - Filter by category, tag, or status

### Engagement
- 💬 **Comment System** - User comments with moderation
- ✅ **Comment Approval** - Review and approve comments before publishing
- 👁️ **View Counter** - Track post views and popularity
- 🔗 **Social Sharing** - Share buttons for Twitter, Facebook, LinkedIn

### Admin Features
- 📊 **Dashboard** - Statistics overview (total posts, published, drafts, comments)
- 📈 **Analytics** - View counts and comment statistics
- 🎨 **Category Manager** - Create and manage categories with colors
- 💬 **Comment Moderation** - Approve or delete comments
- 🔐 **User Authentication** - Secure login with Laravel Breeze

### Public Blog
- 🌐 **Beautiful UI** - Clean, modern design with Tailwind CSS
- 📱 **Responsive Design** - Works perfectly on all devices
- 🔗 **Related Posts** - Suggestions based on category
- 🎨 **Category Badges** - Visual category indicators
- 📅 **Timestamps** - Human-readable dates

## 🛠️ Tech Stack

- **Framework:** Laravel 12
- **Authentication:** Laravel Breeze
- **Database:** MySQL
- **Frontend:** Blade Templates + Tailwind CSS
- **Editor:** SimpleMDE Markdown Editor
- **Markdown Parser:** League CommonMark
- **PHP Version:** 8.3+

## 📦 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL
- Node.js & NPM

### Setup Instructions

1. **Clone the repository**
```bash
   git clone https://github.com/papilamurie/blog-system.git
   cd blog-system
```

2. **Install dependencies**
```bash
   composer install
   npm install
```

3. **Environment setup**
```bash
   cp .env.example .env
   php artisan key:generate
```

4. **Configure database** (Edit `.env`)
```env
   DB_DATABASE=blog_system
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
```

5. **Run migrations**
```bash
   php artisan migrate
```

6. **Seed default data** (optional - adds categories and tags)
```bash
   php artisan db:seed
```

7. **Create storage link** (for image uploads)
```bash
   php artisan storage:link
```

8. **Build assets**
```bash
   npm run build
```

9. **Start the server**
```bash
   php artisan serve
```

Visit: http://localhost:8000



## 🎯 Usage

### For Blog Authors

1. **Register/Login** to your account
2. Go to **Dashboard**
3. Click **"✍️ New Post"**
4. Write your post using Markdown:
   - `**bold**` for **bold text**
   - `*italic*` for *italic text*
   - `# Heading` for headings
   - `- List item` for bullet points
5. Select a **category** and add **tags**
6. Upload a **featured image** (optional)
7. Choose **Draft** to save or **Published** to make it live
8. Click **"Create Post"**

### For Readers

1. Visit the **public blog** homepage
2. **Browse** posts by category or tag
3. **Search** for specific topics
4. **Read** full posts
5. **Leave comments** (login required)

### For Admins

1. **Manage Posts** - Edit, delete, or change status
2. **Moderate Comments** - Approve or remove comments
3. **Manage Categories** - Create categories with custom colors
4. **View Analytics** - Check post views and engagement

## 📁 Project Structure
```
blog-system/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── PostController.php
│   │   │   ├── CategoryController.php
│   │   │   └── CommentController.php
│   │   └── BlogController.php
│   └── Models/
│       ├── Post.php
│       ├── Category.php
│       ├── Tag.php
│       └── Comment.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── CategorySeeder.php
│       └── TagSeeder.php
└── resources/views/
    ├── admin/
    │   ├── posts/
    │   ├── categories/
    │   └── comments/
    └── blog/
        ├── index.blade.php
        └── show.blade.php
```

## 🔐 Security Features

- **User Authentication** - Required for creating/managing posts
- **Authorization** - Users can only manage their own posts
- **Comment Moderation** - Prevent spam with approval system
- **CSRF Protection** - All forms protected
- **SQL Injection Prevention** - Eloquent ORM
- **XSS Protection** - Sanitized outputs
- **Password Hashing** - bcrypt encryption

## 📊 Database Schema

### Posts Table
- User (author)
- Category
- Title, Slug, Excerpt, Content
- Featured Image
- Status (draft/published)
- Views counter
- Published date

### Categories Table
- Name, Slug, Description
- Color (for UI badges)

### Tags Table
- Name, Slug
- Many-to-many with Posts

### Comments Table
- User, Post
- Content
- Approved status

## 🚧 Future Enhancements

- [ ] Multi-author support with roles
- [ ] Email notifications for new comments
- [ ] RSS feed generation
- [ ] Advanced analytics dashboard
- [ ] Post scheduling
- [ ] Image optimization
- [ ] Code syntax highlighting
- [ ] Table of contents auto-generation
- [ ] SEO meta tags customization
- [ ] Newsletter integration

## 📄 License

Open-source software licensed under the [MIT license](LICENSE).

## 👤 Author

**Your Name**
- GitHub: [@papilamurie](https://github.com/papilamurie)
- Portfolio: [Your Portfolio URL]

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - PHP Framework
- [Tailwind CSS](https://tailwindcss.com) - CSS Framework
- [SimpleMDE](https://simplemde.com) - Markdown Editor
- [CommonMark](https://commonmark.thephpleague.com) - Markdown Parser
- [Laravel Breeze](https://laravel.com/docs/starter-kits) - Authentication

---

⭐ If you found this project helpful, please give it a star!

## 📧 Support

For questions or issues, please open an issue on GitHub or contact me at your.email@example.com
