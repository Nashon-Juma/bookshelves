# Bookshelves · Back <!-- omit in toc -->

[![php](https://img.shields.io/static/v1?label=PHP&message=v8.0&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.0&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![mysql](https://img.shields.io/static/v1?label=MySQL&message=v8.0&color=4479A1&style=flat-square&logo=mysql&logoColor=ffffff)](https://www.mysql.com)

[![laravel](https://img.shields.io/static/v1?label=Laravel&message=v8.0&color=ff2d20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com)
[![swagger](https://img.shields.io/static/v1?label=Swagger&message=v3.0&color=85EA2D&style=flat-square&logo=swagger&logoColo=ffffff)](https://swagger.io)

[![nodejs](https://img.shields.io/static/v1?label=NodeJS&message=14.16&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)
[![yarn](https://img.shields.io/static/v1?label=Yarn&message=v1.2&color=2C8EBB&style=flat-square&logo=yarn&logoColor=ffffff)](https://yarnpkg.com/lang/en/)

---

**Table of contents**

- [Demo & documentation](#demo--documentation)
- [**I. Setup**](#i-setup)
  - [*a. Dependencies*](#a-dependencies)
  - [*b. Setup*](#b-setup)
- [**II. Generate eBooks data**](#ii-generate-ebooks-data)
  - [*a. Create directory where store eBooks*](#a-create-directory-where-store-ebooks)
    - [Option 1: Directly store EPUB files](#option-1-directly-store-epub-files)
    - [Option 2: Create symbolic link](#option-2-create-symbolic-link)
  - [*b. Add your own eBooks*](#b-add-your-own-ebooks)
    - [Option: Scan](#option-scan)
    - [Generate books](#generate-books)
  - [*c. Test with demo eBook*](#c-test-with-demo-ebook)

---

## Demo & documentation

🚀 [**bookshelves.ink**](https://bookshelves.ink): demo of Bookshelves  
📚 [**Wiki**](https://bookshelves.ink/api/wiki): wiki for Bookshelves usage, if this link not work check [**files here**](https://gitlab.com/ewilan-riviere/bookshelves-back/-/tree/master/resources/views/pages/api/wiki/content)

---

📀 [**bookshelves-back**](https://gitlab.com/ewilan-riviere/bookshelves-back) : back-end of Bookshelves (current repository)  
🎨 [**bookshelves-front**](https://gitlab.com/ewilan-riviere/bookshelves-front) : front-end of Bookshelves  
📚 [**Documentation**](https://bookshelves.ink/api/documentation): API documentation  

---

## **I. Setup**

### *a. Dependencies*

Extensions for PHP, here for `php8.0`

```bash
sudo apt-get install -y php8.0-xml php8.0-gd
```

For spatie image optimize tools

```bash
sudo apt-get install -y jpegoptim optipng pngquant gifsicle webp
```

```bash
npm install -g svgo
```

### *b. Setup*

Download dependencies

```bash
composer install
```

Execute `setup` and follow guide

```bash
php artisan setup
```

---

## **II. Generate eBooks data**

### *a. Create directory where store eBooks*

**On Bookshelves you have to create directory where you will store your EPUB files: `public/storage/raw/books`**

>If you want to know why, it's simple, EPUB files aren't on git of course, but more it's not really practical to store all ebooks into Bookshelves directly, it's more convenient to set symbolic link. That's reason why we choose to not create an empty directory because if you delete directory to create symbolic link, you will have conflict with git.  
>
>You **can't set `books` directory and a symbolic link INTO `books` directory**, you **have to set a symbolic link instead of `books` directory** cause of League\Flysystem\NotSupportedException which not supported symbolic links to scan directories (but **it works if the scan directory is a symbolic link**).  
>
>You can store EPUB files into `public/storage/raw/books` directory or you can create a symbolic link that is really more convenient. Of course, Bookshelves scan recursively this directory, you can have sub directories if you want.  

#### Option 1: Directly store EPUB files

```bash
mkdir public/storage/raw/books
```

```bash
.
+-- public
|   +-- storage
|     +-- raw
|       +-- books
|         +-- my-ebook.epub
|         +-- ...
```

#### Option 2: Create symbolic link

```bash
# pwd => ..bookshelves-back/public/storage/raw
ln -s /home/user/directory-of-ebooks books
```

```bash
.
+-- public
|   +-- storage
|     +-- raw
|       +-- books -> /home/user/directory-of-ebooks
```

### *b. Add your own eBooks*

#### Option: Scan

You can scan `books` directory to get a list of your EPUB files to know if everything works.

```bash
php artisan bookshelves:scan -v
```

#### Generate books

Add EPUB files in `public/storage/raw/books` and execute Epub Parser

> `php artisan bookshelves:generate -h` to check options

```bash
# for fresh installation (erase current database) with force option for production
php artisan bookshelves:generate -fF
```

### *c. Test with demo eBook*

If you want to test Bookshelves, you can use `bookshelves:sample` to generate data from libre eBooks

> `php artisan bookshelves:sample -h` to check options

```bash
php artisan bookshelves:sample
```

---

## **TODO** <!-- omit in toc -->

- [ ] Logs for EpubParser
- [ ] Improve libre ebooks meta
- [ ] Add attribute on each method for Controller
- [ ] Check attributes
  - <https://www.amitmerchant.com/how-to-use-php-80-attributes>
  - <https://stitcher.io/blog/attributes-in-php-8>
  - <https://grafikart.fr/tutoriels/attribut-php8-1371>
- [ ] numberOfPages: <https://idpf.github.io/epub-guides/package-metadata/#schema-numberOfPages>
  - async epubparser for Google data
- [ ] Add explanation form each part of EpubParser
- [ ] spatie/laravel-medialibrary
  - <https://spatie.be/docs/laravel-medialibrary/v9/converting-images/optimizing-converted-images>
  - <https://spatie.be/docs/laravel-medialibrary/v9/handling-uploads-with-media-library-pro/handling-uploads-with-vue>
  - conversions name
    - <https://spatie.be/docs/laravel-medialibrary/v9/advanced-usage/naming-generated-files>
    - <https://spatie.be/docs/laravel-medialibrary/v9/converting-images/defining-conversions>
- [ ] larastan upgrade level
- [ ] more tests for models
