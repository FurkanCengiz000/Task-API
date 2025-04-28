# Task Management API (TDD Approach)

Bu proje, bir iş görüşmesi sürecinde alınan geri bildirimler doğrultusunda yeniden simüle edilerek geliştirilmiştir.  
TDD (Test Driven Development) prensipleri kullanılarak yazılmıştır.

## Özellikler

- Task oluşturma (Create)
- Task güncelleme (Update)
- Task silme (Delete)
- API üzerinden JSON formatında veri yönetimi
- Observer ile otomatik UUID (code) üretimi
- Resource yapısı ile düzenli veri dönüşü
- DTO yapısı ile temiz veri transferi
- Exception Handling (404 ve 422 yönetimi)
- Feature Testler ile güvence altına alınmış fonksiyonlar

## Kullanılan Teknolojiler

- Laravel 10+
- PHP 8.1+
- MySQL
- PHPUnit (Feature Testler)

## Proje Amacı

Bu proje, yapılan görüşme sonrası tarafıma iletilen feedbackler doğrultusunda (Observer kullanımı, Resource yönetimi, Best API Practices, DTO kavramı) eksiklerimi kapatmak ve süreci birebir uygulamalı olarak tamamlamak amacıyla geliştirilmiştir.

## Kurulum

```bash
git clone https://github.com/FurkanCengiz000/Task-API.git
cd Task-API
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan test
