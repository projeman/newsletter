# sesuva/newsletter

Newsletter abone yönetimi paketi. E-posta listeleri için basit, bağımsız çözüm.

![PHP Version](https://img.shields.io/badge/PHP-%3E%3D8.3-blue)
![License](https://img.shields.io/badge/License-MIT-green)

## Kurulum

```bash
composer require sesuva/newsletter
```

### Veritabanı Migrasyonları

```bash
php artisan migrate --path=vendor/sesuva/newsletter/database/migrations
```

Veya otomatik olarak:

```bash
php artisan vendor:publish --tag=sesuva-newsletter-migrations
php artisan migrate
```

## Kullanım

### Repository ile Çalışma

```php
use Sesuva\Newsletter\Repositories\SubscriberRepository;

$repo = app(SubscriberRepository::class);

// Abone ol
$subscriber = $repo->subscribe('user@example.com', 'Kullanıcı Adı');

// Abone ol çık
$repo->unsubscribe('user@example.com');

// Doğrula
$subscriber = $repo->verify($token);

// Abone bul
$subscriber = $repo->findByEmail('user@example.com');

// Tüm abone sayısı
$count = $repo->count();

// Sayfasız liste
$subscribers = $repo->getSubscribed(perPage: 100);
```

### Model ile Çalışma

```php
use Sesuva\Newsletter\Models\Subscriber;

// Aktif aboneler
$active = Subscriber::subscribed()->get();

// E-posta ile ara
$subscriber = Subscriber::byEmail('user@example.com')->first();

// Doğrulanmamış aboneler
$pending = Subscriber::where('verified_at', null)->get();
```

## Veri Modeli

**newsletter_subscribers**
- `id` - Primary Key
- `email` - E-posta adresi (unique)
- `name` - Abone adı
- `is_subscribed` - Aktif abone mı?
- `subscribed_at` - Abone olma tarihi
- `unsubscribed_at` - Abone ol çıkma tarihi
- `verification_token` - E-posta doğrulama tokeni
- `verified_at` - E-posta doğrulama tarihi
- `timestamps` - Oluşturulma ve güncellenme tarihleri

## Özellikleri

- 📧 Abone yönetimi
- ✅ E-posta doğrulama
- 🔄 Subscribe/Unsubscribe
- 🔍 Arama ve filtreleme
- 📊 İstatistikler
- 🗂️ Sayfalama

## Lisans

MIT License - Ayrıntılar için `LICENSE` dosyasına bakın.
