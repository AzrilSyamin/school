
# School Data
Sebuah project yang dibuat sambil berlajar PHP Procedural, 
project ini menerapkan konsep CRUD, 
yang dibahagikan kepada 3 Level Role
- Admin/SuperAdmin
- Moderator
- Member

Walau bagaimana pon project ini masih perlu di tingkatkan lagi security,
jika anda ingin menggunakan project ini di production, 
pastikan anda sudah menambahkan langkah keselamatan terlebih dahulu, 
apa apa risiko yang anda hadapi tidak akan ditanggung oleh pihak saya

## Tech Stack 
- Html
- Css (Bootstrap 4)
- Javascript
- Php Procedural
- Mysql

## Dalam Perancangan
- Tukar ke PHP OOP / Laravel
- Perubahan Role
  - Admin boleh tambah Role
  - Admin boleh custom Role
- Perubahan UI
- Paparkan Jadual untuk halaman pertama
- Composer
- ETC

## Gambaran Projek

Projek ini digambarkan sebuah sistem sekolah, 
data yang disimpan adalah data:
- Teacher (Guru)
- Subject (Mata Pelajaran)
- Class (Kelas/Bilik Darjah)
- Student (Pelajar)

#### Admin (Owner)
 - Add Teacher,Edit Teacher,Delete Teacher
 - Add Subject,Edit Subject,Delete Subject
 - Add Class,Edit Class,Delete Subject
 - Add Student,Edit Student,Delete Student

#### Moderator (Kerani)
 - Add Subject,Edit Subject
 - Add Class,Edit Class
 - Add Student,Edit Student

#### Member (Guru)
 - Add Subject,Edit Subject
 - Add Class,Edit Class
 - Add Student,Edit Student

Untuk Moderator dan Member role mereka sama kerana pada asalnya hanya ingin buat 2 role,
jadi role ketiga masih dalam perancangan akan datang(Jika ada)

## Test Drive
Project ini sudah boleh digunakan, jika anda ingin mencubanya boleh ikut langkah dibawah

```
git clone https://gitlab.com/azrilsyamin/school.git
```
kemudian ada 2 cara untuk menjalankan project ini

### Cara 1 (Recommend)
Anda tidak perlu buat database, database akan di generate secara auto ketika pertama kali anda menajalankan project

masuk ke lokasi file anda disimpan
```
cd school
```
jalankan perintah dibawah
```
php -S http://localhost:8000
```
### Cara 2 (Manual)
pergi ke project directory
```
cd PATH/school/
```
copy atau rename file config-example.php
```
cp config-example.php config.php
```
edit file config.php
```
nano config.php
```
insert your detail in :
- Database User
- Database Password
- Database Name
- Web Url
```
$host = "localhost";
$user = "";     // Database User
$pass = "";     // Database Password
$db_name = "";  // Database Name 

function myUrl($url = null)
{
  // $base_url = 'http://localhost.test';
  $base_url = ''; // Web Url
  if ($url != null) {
    return $base_url . "/" . $url;
  } else {
    return $base_url;
  }
}
```
Selesai, sekarang jalankan project ikut Wel Url yang anda masukkan

**NOTE:
Cara kedua ini anda perlu setup tambahan pada local komputer anda, untuk web url yang anda masukkan boleh berjalan di local komputer**

