@extends('layouts.app')

@section('title', 'Çerez Politikası - ' . App\Models\Setting::getValue('site_name'))

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Çerez Politikası</h1>
            <p class="text-lg text-gray-600">Son güncelleme: {{ date('d.m.Y') }}</p>
        </div>

        <!-- Content -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="prose prose-lg max-w-none">
                
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">1. Çerez Nedir?</h2>
                <p class="text-gray-700 mb-6">
                    Çerezler (cookies), web sitelerini ziyaret ettiğinizde tarayıcınız tarafından 
                    bilgisayarınıza veya mobil cihazınıza kaydedilen küçük metin dosyalarıdır. 
                    Bu dosyalar, web sitesinin daha iyi çalışmasını sağlar ve kullanıcı deneyimini geliştirir.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">2. Çerez Türleri</h2>
                
                <h3 class="text-xl font-semibold text-gray-800 mb-3">2.1 Zorunlu Çerezler</h3>
                <p class="text-gray-700 mb-4">
                    Web sitesinin temel işlevlerini yerine getirmesi için gerekli olan çerezlerdir. 
                    Bu çerezler olmadan site düzgün çalışmaz.
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Oturum yönetimi çerezleri</li>
                    <li>Güvenlik çerezleri</li>
                    <li>Form verilerini koruma çerezleri</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">2.2 Performans Çerezleri</h3>
                <p class="text-gray-700 mb-4">
                    Web sitesinin performansını ölçmek ve kullanıcı deneyimini geliştirmek için kullanılır.
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Sayfa yükleme süreleri</li>
                    <li>Ziyaret edilen sayfalar</li>
                    <li>Hata raporları</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">2.3 Fonksiyonel Çerezler</h3>
                <p class="text-gray-700 mb-4">
                    Kullanıcı tercihlerini hatırlayarak kişiselleştirilmiş deneyim sunar.
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Dil tercihi</li>
                    <li>Bölge ayarları</li>
                    <li>Kullanıcı tercihleri</li>
                </ul>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">2.4 Analitik Çerezler</h3>
                <p class="text-gray-700 mb-4">
                    Web sitesi trafiğini analiz etmek ve kullanım istatistikleri toplamak için kullanılır.
                </p>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li>Google Analytics</li>
                    <li>Ziyaretçi sayıları</li>
                    <li>En popüler sayfalar</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">3. Kullandığımız Çerezler</h2>
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Çerez Adı</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Amaç</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Süre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">_session</td>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">Oturum yönetimi</td>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">Oturum sonuna kadar</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">_csrf</td>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">Güvenlik</td>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">Oturum sonuna kadar</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">_ga</td>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">Google Analytics</td>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">2 yıl</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">_gid</td>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">Google Analytics</td>
                                <td class="px-4 py-2 text-sm text-gray-700 border-b">24 saat</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">4. Çerez Yönetimi</h2>
                <p class="text-gray-700 mb-4">
                    Çerezleri yönetmek için tarayıcınızın ayarlarını kullanabilirsiniz. 
                    Ancak bazı çerezleri devre dışı bırakmanız web sitesinin düzgün çalışmamasına neden olabilir.
                </p>

                <h3 class="text-xl font-semibold text-gray-800 mb-3">4.1 Tarayıcı Ayarları</h3>
                <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2">
                    <li><strong>Chrome:</strong> Ayarlar > Gizlilik ve güvenlik > Çerezler</li>
                    <li><strong>Firefox:</strong> Seçenekler > Gizlilik ve güvenlik > Çerezler</li>
                    <li><strong>Safari:</strong> Tercihler > Gizlilik > Çerezler</li>
                    <li><strong>Edge:</strong> Ayarlar > Çerezler ve site izinleri</li>
                </ul>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">5. Üçüncü Taraf Çerezleri</h2>
                <p class="text-gray-700 mb-6">
                    Web sitemizde Google Analytics gibi üçüncü taraf hizmetler kullanıyoruz. 
                    Bu hizmetlerin kendi çerez politikaları bulunmaktadır. Bu politikaları 
                    ilgili hizmet sağlayıcılarının web sitelerinden inceleyebilirsiniz.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">6. Çerez Onayı</h2>
                <p class="text-gray-700 mb-6">
                    Web sitemizi ilk ziyaret ettiğinizde çerez kullanımı hakkında bilgilendirileceksiniz. 
                    Zorunlu olmayan çerezler için onayınızı verebilir veya reddedebilirsiniz. 
                    Onayınızı istediğiniz zaman değiştirebilirsiniz.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">7. Çerez Silme</h2>
                <p class="text-gray-700 mb-6">
                    Tarayıcınızdan çerezleri silebilirsiniz. Ancak bu işlem web sitesinin 
                    bazı özelliklerinin çalışmamasına neden olabilir. Çerezleri silmek için 
                    tarayıcınızın ayarlar menüsünü kullanabilirsiniz.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">8. Politika Değişiklikleri</h2>
                <p class="text-gray-700 mb-6">
                    Bu çerez politikasını zaman zaman güncelleyebiliriz. Önemli değişiklikler 
                    durumunda web sitemizde duyuru yapacağız. Güncel politika her zaman 
                    bu sayfada yayınlanacaktır.
                </p>

                <h2 class="text-2xl font-semibold text-gray-900 mb-4">9. İletişim</h2>
                <p class="text-gray-700 mb-4">
                    Çerez politikamız hakkında sorularınız için bizimle iletişime geçebilirsiniz:
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
