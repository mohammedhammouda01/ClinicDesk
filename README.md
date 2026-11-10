# ClinicDesk

نظام إدارة عيادة بأدوار (Admin / Doctor / Patient)، مبني بـ PHP (MVC) و MySQL وواجهة AdminLTE v3.

## Tech Stack
- PHP 8.2 + Apache
- MySQL 8.0
- AdminLTE 3
- Docker & Docker Compose

## Run with Docker
```bash
git clone https://github.com/mohammedhammouda01/ClinicDesk.git
cd ClinicDesk
docker compose up -d --build
```
ثم افتح: http://localhost:8080

أو باستخدام Make: `make build && make run`

## Stop & Cleanup
```bash
docker compose down        # إيقاف الكونتينرات
docker compose down -v     # إيقاف وحذف بيانات الداتابيس
```

## Configuration
- Web: المنفذ 8080
- Database: `clinicdesk_db` (يتم استيراده تلقائياً من `database/clinicdesk_db.sql` عند أول تشغيل)
- متغيرات البيئة (مضبوطة في docker-compose.yml): `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`

## How to Test
1. افتح http://localhost:8080
2. سجّل الدخول بحساب موجود (اكتب هنا بريد وكلمة سر حساب تجريبي من الداتابيس)
3. تصفّح لوحة التحكم

## Attribution
المشروع من إعدادي. واجهة AdminLTE v3 (MIT License).