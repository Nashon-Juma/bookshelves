# Bookshelves · Back <!-- omit in toc -->

[![php](https://img.shields.io/static/v1?label=PHP&message=v8.0&color=777bb4&style=flat-square&logo=php&logoColor=ffffff)](https://www.php.net)
[![composer](https://img.shields.io/static/v1?label=Composer&message=v2.0&color=885630&style=flat-square&logo=composer&logoColor=ffffff)](https://getcomposer.org)
[![mysql](https://img.shields.io/static/v1?label=MySQL&message=v8.0&color=4479A1&style=flat-square&logo=mysql&logoColor=ffffff)](https://www.mysql.com)

[![laravel](https://img.shields.io/static/v1?label=Laravel&message=v8.0&color=ff2d20&style=flat-square&logo=laravel&logoColor=ffffff)](https://laravel.com)
[![nodejs](https://img.shields.io/static/v1?label=NodeJS&message=14.16&color=339933&style=flat-square&logo=node.js&logoColor=ffffff)](https://nodejs.org/en)
[![yarn](https://img.shields.io/static/v1?label=Yarn&message=v1.2&color=2C8EBB&style=flat-square&logo=yarn&logoColor=ffffff)](https://yarnpkg.com/lang/en/)

📀 [**bookshelves-back**](https://gitlab.com/ewilan-riviere/bookshelves-back) : back-end of Bookshelves (current repository)  
🎨 [**bookshelves-front**](https://gitlab.com/ewilan-riviere/bookshelves-front) : front-end of Bookshelves  

💻 [**bookshelves.ink**](https://bookshelves.ink): front demo  
📚 [**bookshelves.ink/docs**](https://bookshelves.ink/docs): Documentation API  
📚 [**bookshelves.ink/wiki**](https://bookshelves.ink/wiki): wiki for Bookshelves usage, if this link not work check [**files here**](https://gitlab.com/ewilan-riviere/bookshelves-back/-/tree/master/resources/views/pages/wiki/content)

**Table of contents**

- [**Setup**](#setup)
  - [*a. Dependencies*](#a-dependencies)
  - [*b. Setup*](#b-setup)
    - [Generate books](#generate-books)
  - [*c. Test with demo eBook*](#c-test-with-demo-ebook)
- [API Doc](#api-doc)

## **Setup**

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

#### Generate books

Add EPUB files in `public/storage/raw/books` and execute Epub Parser

> `php artisan bookshelves:generate -h` to check options

```bash
# for fresh installation (erase tables with books data) with force option for production
php artisan bookshelves:generate -fF
```

### *c. Test with demo eBook*

If you want to test Bookshelves, you can use `bookshelves:sample` to generate data from libre eBooks

> `php artisan bookshelves:sample -h` to check options

```bash
php artisan bookshelves:sample
```

## API Doc

API documentation is generated with [**knuckleswtf/scribe**](https://scribe.knuckles.wtf/laravel/)

```bash
php artisan scribe:generate
```

## **TODO** <!-- omit in toc -->

- API doc
  - [ ] improve doc responseField
  - [ ] improve bind routes
- [ ] Logs for EpubParser
- [ ] Improve libre ebooks meta
- [ ] Add attribute on each method for Controller
- [ ] Check attributes
  - <https://www.amitmerchant.com/how-to-use-php-80-attributes>
  - <https://stitcher.io/blog/attributes-in-php-8>
  - <https://grafikart.fr/tutoriels/attribut-php8-1371>
- [ ] numberOfPages: <https://idpf.github.io/epub-guides/package-metadata/#schema-numberOfPages>
- [ ] Add explanation form each part of EpubParser
- [ ] spatie/laravel-medialibrary
  - <https://spatie.be/docs/laravel-medialibrary/v9/converting-images/optimizing-converted-images>
  - <https://spatie.be/docs/laravel-medialibrary/v9/handling-uploads-with-media-library-pro/handling-uploads-with-vue>
  - conversions name
    - <https://spatie.be/docs/laravel-medialibrary/v9/advanced-usage/naming-generated-files>
    - <https://spatie.be/docs/laravel-medialibrary/v9/converting-images/defining-conversions>
- [ ] larastan upgrade level
- [ ] more tests for models
- [ ] authors notes WIP
- [ ] opds <https://specs.opds.io/opds-1.2>
