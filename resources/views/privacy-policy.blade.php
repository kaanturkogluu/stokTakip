@extends('layouts.app')

@section('title', 'Gizlilik Politikası - ' . App\Models\Setting::getValue('site_name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Gizlilik Politikası</h1>
            <p class="text-lg text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="prose prose-lg max-w-none">
                
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. Giriş</h2>
                <p class="text-gray-700 mb-6">
                    {{ App\Models\Setting::getValue('site_name') }} olarak, kişisel verilerinizin korunması bizim için büyük önem taşımaktadır. 
                    Bu gizlilik politikası, web sitemizi ziyaret ettiğinizde veya hizmetlerimizi kullandığınızda 
                    kişisel bilgilerinizin nasıl toplandığını, kullanıldığını ve korunduğunu açıklamaktadır.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. Toplanan Bilgiler</h2>
                <p class="text-gray-700 mb-4">Aşağıdaki türde bilgileri toplayabiliriz:</p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li><strong>Kişisel Bilgiler:</strong> Ad, soyad, e-posta adresi, telefon numarası</li>
                    <li><strong>İletişim Bilgileri:</strong> Adres, şehir, posta kodu</li>
                    <li><strong>Teknik Bilgiler:</strong> IP adresi, tarayıcı türü, işletim sistemi</li>
                    <li><strong>Kullanım Bilgileri:</strong> Site ziyaret süresi, sayfa görüntüleme sayısı</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. Bilgilerin Kullanımı</h2>
                <p class="text-gray-700 mb-4">Topladığımız bilgileri aşağıdaki amaçlarla kullanırız:</p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Hizmetlerimizi sunmak ve geliştirmek</li>
                    <li>Müşteri desteği sağlamak</li>
                    <li>Ürün ve hizmet önerilerinde bulunmak</li>
                    <li>Yasal yükümlülüklerimizi yerine getirmek</li>
                    <li>Site güvenliğini sağlamak</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. Bilgi Paylaşımı</h2>
                <p class="text-gray-700 mb-6">
                    Kişisel bilgilerinizi üçüncü taraflarla paylaşmayız, ancak aşağıdaki durumlar hariç:
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Yasal zorunluluklar</li>
                    <li>Mahkeme kararları</li>
                    <li>Kamu güvenliği</li>
                    <li>Hizmet sağlayıcılarımız (gizlilik sözleşmesi ile)</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. Veri Güvenliği</h2>
                <p class="text-gray-700 mb-6">
                    Kişisel verilerinizi korumak için uygun teknik ve idari güvenlik önlemlerini alırız. 
                    Verileriniz SSL şifreleme ile korunur ve güvenli sunucularda saklanır.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. Çerezler (Cookies)</h2>
                <p class="text-gray-700 mb-6">
                    Web sitemizde kullanıcı deneyimini geliştirmek için çerezler kullanırız. 
                    Çerez politikamız hakkında detaylı bilgi için 
                    <a href="{{ route('cookie-policy') }}" class="text-blue-600 hover:text-blue-800">Çerez Politikası</a> 
                    sayfamızı ziyaret edebilirsiniz.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. Kullanıcı Hakları</h2>
                <p class="text-gray-700 mb-4">KVKK kapsamında aşağıdaki haklara sahipsiniz:</p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Kişisel verilerinizin işlenip işlenmediğini öğrenme</li>
                    <li>İşlenen verileriniz hakkında bilgi talep etme</li>
                    <li>Verilerinizin işlenme amacını öğrenme</li>
                    <li>Yurt içi/yurt dışı aktarılan üçüncü kişileri bilme</li>
                    <li>Eksik veya yanlış işlenmiş verilerin düzeltilmesini isteme</li>
                    <li>Belirli şartlar altında verilerin silinmesini isteme</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">8. İletişim</h2>
                <p class="text-gray-700 mb-4">
                    Gizlilik politikamız hakkında sorularınız için bizimle iletişime geçebilirsiniz:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700"><strong>E-posta:</strong> {{ App\Models\Setting::getValue('contact_email') }}</p>
                    <p class="text-gray-700"><strong>Telefon:</strong> {{ App\Models\Setting::getValue('contact_phone') }}</p>
                    <p class="text-gray-700"><strong>Adres:</strong> {{ App\Models\Setting::getValue('contact_address') }}</p>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">9. Politika Değişiklikleri</h2>
                <p class="text-gray-700 mb-6">
                    Bu gizlilik politikasını zaman zaman güncelleyebiliriz. Önemli değişiklikler durumunda 
                    size e-posta ile bildirimde bulunacağız. Politikanın güncel halini web sitemizden takip edebilirsiniz.
                </p>

            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                <i class="fas fa-home mr-2"></i>
                Ana Sayfaya Dön
            </a>
        </div>
    </div>
</div>
@endsection
