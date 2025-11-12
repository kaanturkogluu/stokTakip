# Admin Rolleri ve Yetkileri

## Rol Hiyerarşisi

Sistemde 4 farklı rol bulunmaktadır:

### 1. 🔴 **Süper Admin (super_admin)**
**En yüksek yetki seviyesi**

**Yetkiler:**
- ✅ Tüm işlemlere erişim (telefon, müşteri, satış, vb.)
- ✅ Admin kullanıcıları ekleme/düzenleme
- ✅ **Admin kullanıcılarını silme** (sadece super_admin)
- ✅ İşlem geçmişi (audit logs) görüntüleme
- ✅ Tüm özel yetkilere otomatik erişim
- ✅ Sistem ayarlarına erişim

**Kısıtlamalar:**
- ❌ Kendi hesabını silemez

---

### 2. 🔵 **Admin (admin)**
**Yönetim yetkileri**

**Yetkiler:**
- ✅ Tüm işlemlere erişim (telefon, müşteri, satış, vb.)
- ✅ Admin kullanıcıları ekleme/düzenleme
- ✅ İşlem geçmişi (audit logs) görüntüleme
- ✅ Özel yetkiler tanımlanabilir

**Kısıtlamalar:**
- ❌ Admin kullanıcılarını silemez (sadece super_admin)
- ❌ Özel yetkiler tanımlanmamışsa bazı işlemler kısıtlanabilir

---

### 3. 🟢 **Yönetici (manager)**
**Orta seviye yetkiler**

**Yetkiler:**
- ✅ Genel işlemlere erişim (telefon, müşteri, satış, vb.)
- ✅ Özel yetkiler tanımlanabilir

**Kısıtlamalar:**
- ❌ Admin yönetimi yapamaz
- ❌ İşlem geçmişi göremez
- ❌ Özel yetkiler tanımlanmamışsa bazı işlemler kısıtlanabilir

---

### 4. 🟡 **Personel (staff)**
**En düşük yetki seviyesi**

**Yetkiler:**
- ✅ Temel işlemlere erişim (telefon görüntüleme, satış yapma, vb.)
- ✅ Özel yetkiler tanımlanabilir

**Kısıtlamalar:**
- ❌ Admin yönetimi yapamaz
- ❌ İşlem geçmişi göremez
- ❌ Veri yönetimi (marka, model, renk ekleme) yapamaz (gelecekte eklenebilir)
- ❌ Özel yetkiler tanımlanmamışsa çoğu işlem kısıtlanabilir

---

## Özel Yetkiler (Permissions)

Her rol için özel yetkiler tanımlanabilir:

- `phones.create` - Telefon ekleme
- `phones.update` - Telefon düzenleme
- `phones.delete` - Telefon silme
- `sales.create` - Satış yapma
- `customers.create` - Müşteri ekleme
- `customers.update` - Müşteri düzenleme
- `payments.process` - Ödeme alma
- `reports.view` - Rapor görüntüleme

**Not:** Süper Admin tüm yetkilere otomatik sahiptir, özel yetki tanımlamaya gerek yoktur.

---

## Mevcut Durum

**Şu anda aktif olan rol kontrolleri:**
- ✅ Admin yönetimi (sadece admin ve super_admin)
- ✅ Admin silme (sadece super_admin)
- ✅ İşlem geçmişi görüntüleme (sadece admin ve super_admin)

**Gelecekte eklenebilecek kontroller:**
- ⏳ Telefon ekleme/düzenleme/silme için rol kontrolü
- ⏳ Satış yapma için rol kontrolü
- ⏳ Müşteri yönetimi için rol kontrolü
- ⏳ Rapor görüntüleme için rol kontrolü
- ⏳ Veri yönetimi (marka, model, renk) için rol kontrolü

---

## Örnek Kullanım Senaryoları

### Senaryo 1: Mağaza Sahibi
- **Rol:** Süper Admin
- **Amaç:** Tüm sisteme tam erişim, admin yönetimi

### Senaryo 2: Müdür
- **Rol:** Admin
- **Amaç:** Günlük işlemleri yönetme, yeni personel ekleme

### Senaryo 3: Satış Sorumlusu
- **Rol:** Yönetici
- **Amaç:** Satış yapma, müşteri yönetimi, rapor görüntüleme

### Senaryo 4: Satış Elemanı
- **Rol:** Personel
- **Özel Yetkiler:** `sales.create`, `payments.process`
- **Amaç:** Sadece satış yapma ve ödeme alma

---

## Notlar

- Tüm işlemler audit log'a kaydedilir
- Rol değişiklikleri sadece admin ve super_admin tarafından yapılabilir
- Her kullanıcının son giriş bilgileri takip edilir
- Kullanıcılar aktif/pasif yapılabilir

