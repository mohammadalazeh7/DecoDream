DecoDream - متجر إلكتروني لإدارة المنتجات والطلبات
===============================================

نظرة عامة
---------
مشروع DecoDream هو تطبيق متجر إلكتروني مبني باستخدام Laravel لتخزين وإدارة المنتجات، الصور، الأقسام، الألوان، الأقمشة، الأخشاب، والطلبات، مع نظام مستخدمين وموظفين وصلاحيات.

الميزات الرئيسية
----------------
- إدارة المنتجات والصور والأنواع (الألوان، الأقمشة، الأخشاب)
- سلة/طلبات وقطع الطلب (Order + OrderItem)
- مفضلات المستخدمين
- نظام موظفين وصلاحيات (Roles)
- إرسال إيميلات (ترحيب، كود تحقق، تحديث ملف)
- واجهة API موثقة (OpenAPI / Postman)

التقنيات المستخدمة
------------------
- PHP 8+ و Laravel
- Composer لإدارة الحزم
- Vite + NPM للواجهات الأمامية
- PHPUnit للاختبارات

المتطلبات
---------
- PHP 8 أو أحدث
- Composer
- Node.js و npm
- خادم قاعدة بيانات (MySQL / MariaDB)
- Laragon أو بيئة تطوير محلية مماثلة (اختياري)

إعداد المشروع وتشغيله محلياً
---------------------------
1. استنساخ المستودع:

   git clone <repo-url>
   cd DecoDream

2. تثبيت تبعيات PHP:

   composer install

3. تثبيت تبعيات JavaScript:

   npm install

4. إعداد ملف البيئة:

   - انسخ `.env.example` إلى `.env` ثم عدّل إعدادات قاعدة البيانات والبريد.
   - أنشئ مفتاح التطبيق:

     php artisan key:generate

5. تشغيل قواعد البيانات والهجرات:

   php artisan migrate --seed

6. بناء الأصول (خلال التطوير):

   npm run dev

7. تشغيل الخادم المحلي:

   php artisan serve

ملاحظة: يمكنك استخدام Laragon أو أي بيئة تطوير محلية لتشغيل المشروع بسهولة.

توثيق الـ API وملفات مفيدة
-------------------------
- ملف OpenAPI: [openapi.yaml](openapi.yaml)
- مجموعة Postman: [thunder-collection_postman_APIs Authentication.json](thunder-collection_postman_APIs%20Authentication.json)

اختبارات
--------
لتشغيل الاختبارات الوحدوية:

   ./vendor/bin/phpunit

المساهمة
--------
- فتح Issue أو إرسال Pull Request للميزات أو التصحيحات.
- اتبع قواعد التزام واضحة (commit messages) ووصف التغييرات.

الرخصة
------
أضف هنا نوع الرخصة (مثال: MIT) أو رابط إلى ملف `LICENSE` إن وجد.

اتصال
-----
لمزيد من المعلومات أو أسئلة التطوير، راجع `README` في المستودع أو افتح Issue على GitHub.

ملفات مهمة في المشروع
---------------------
- الكود الأساسي: `app/`
- مسارات الـ API: `routes/api.php`
- تكوينات: `config/`
- ملف OpenAPI: [openapi.yaml](openapi.yaml)
- مجموعة Postman: [thunder-collection_postman_APIs Authentication.json](thunder-collection_postman_APIs%20Authentication.json)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
