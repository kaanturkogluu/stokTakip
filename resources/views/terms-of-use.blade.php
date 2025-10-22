@extends('layouts.app')

@section('title', 'Kullanım Şartları - ' . App\Models\Setting::getValue('site_name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Kullanım Şartları</h1>
            <p class="text-lg text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="prose prose-lg max-w-none">
                
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. Genel Hükümler</h2>
                <p class="text-gray-700 mb-6">
                    Bu kullanım şartları, {{ App\Models\Setting::getValue('site_name') }} web sitesini kullanırken uymanız gereken kuralları belirler. 
                    Siteyi kullanarak bu şartları kabul etmiş sayılırsınız. Şartları kabul etmiyorsanız, 
                    lütfen siteyi kullanmayınız.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. Hizmet Tanımı</h2>
                <p class="text-gray-700 mb-4">{{ App\Models\Setting::getValue('site_name') }} aşağıdaki hizmetleri sunmaktadır:</p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Telefon satış ve pazarlama hizmetleri</li>
                    <li>Teknik destek ve servis hizmetleri</li>
                    <li>Müşteri danışmanlığı</li>
                    <li>Online ürün kataloğu</li>
                    <li>İletişim ve bilgilendirme hizmetleri</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. Kullanıcı Yükümlülükleri</h2>
                <p class="text-gray-700 mb-4">Siteyi kullanırken aşağıdaki kurallara uymanız gerekmektedir:</p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Doğru ve güncel bilgiler sağlamak</li>
                    <li>Başkalarının haklarını ihlal etmemek</li>
                    <li>Yasadışı faaliyetlerde bulunmamak</li>
                    <li>Site güvenliğini tehdit edici davranışlarda bulunmamak</li>
                    <li>Telif hakları ve fikri mülkiyet haklarına saygı göstermek</li>
                    <li>Spam veya zararlı içerik göndermemek</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. Yasaklanan Kullanımlar</h2>
                <p class="text-gray-700 mb-4">Aşağıdaki faaliyetler kesinlikle yasaktır:</p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Virüs, malware veya zararlı kod yaymak</li>
                    <li>Hacking, cracking veya güvenlik açıklarını istismar etmek</li>
                    <li>Sahte kimlik kullanmak</li>
                    <li>Başkalarının hesaplarını ele geçirmeye çalışmak</li>
                    <li>Spam e-posta göndermek</li>
                    <li>Telif hakkı ihlali yapmak</li>
                    <li>Yasadışı içerik paylaşmak</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. Fikri Mülkiyet Hakları</h2>
                <p class="text-gray-700 mb-6">
                    Web sitesindeki tüm içerik, tasarım, logo, marka ve yazılımlar {{ App\Models\Setting::getValue('site_name') }}'in 
                    fikri mülkiyetidir. Bu içeriklerin izinsiz kullanımı yasaktır ve yasal işlem 
                    başlatılabilir.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. Hizmet Kesintileri</h2>
                <p class="text-gray-700 mb-6">
                    Teknik bakım, güncelleme veya diğer nedenlerle hizmetlerimizde geçici kesintiler 
                    yaşanabilir. Bu durumlardan dolayı oluşabilecek zararlardan sorumlu değiliz.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. Üçüncü Taraf Bağlantıları</h2>
                <p class="text-gray-700 mb-6">
                    Web sitemizde üçüncü taraf web sitelerine bağlantılar bulunabilir. Bu sitelerin 
                    içeriği ve gizlilik politikalarından sorumlu değiliz. Bu siteleri kendi 
                    sorumluluğunuzda ziyaret ediniz.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">8. Sorumluluk Sınırları</h2>
                <p class="text-gray-700 mb-6">
                    {{ App\Models\Setting::getValue('site_name') }}, web sitesinin kullanımından doğabilecek doğrudan veya dolaylı 
                    zararlardan sorumlu değildir. Hizmetlerimiz "olduğu gibi" sunulmaktadır.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">9. Hesap Askıya Alma ve Sonlandırma</h2>
                <p class="text-gray-700 mb-6">
                    Bu kullanım şartlarını ihlal etmeniz durumunda hesabınızı askıya alabilir veya 
                    sonlandırabiliriz. Bu durumda önceden bildirimde bulunma yükümlülüğümüz yoktur.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">10. Uygulanacak Hukuk</h2>
                <p class="text-gray-700 mb-6">
                    Bu kullanım şartları Türk hukukuna tabidir. Herhangi bir uyuşmazlık durumunda 
                    İstanbul mahkemeleri yetkilidir.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">11. Şartların Değiştirilmesi</h2>
                <p class="text-gray-700 mb-6">
                    Bu kullanım şartlarını zaman zaman güncelleyebiliriz. Önemli değişiklikler 
                    durumunda web sitemizde duyuru yapacağız. Değişiklikler yayınlandığı tarihten 
                    itibaren geçerli olacaktır.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">12. İletişim</h2>
                <p class="text-gray-700 mb-4">
                    Kullanım şartları hakkında sorularınız için bizimle iletişime geçebilirsiniz:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700"><strong>E-posta:</strong> {{ App\Models\Setting::getValue('contact_email') }}</p>
                    <p class="text-gray-700"><strong>Telefon:</strong> {{ App\Models\Setting::getValue('contact_phone') }}</p>
                    <p class="text-gray-700"><strong>Adres:</strong> {{ App\Models\Setting::getValue('contact_address') }}</p>
                </div>

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
