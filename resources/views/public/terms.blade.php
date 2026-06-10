@extends('layout.app')

@section('title', 'Conditions Générales')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-20">
    <div class="space-y-12">
        <div class="text-center space-y-4">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 leading-tight">Conditions <span class="text-secondary italic font-display">Générales</span></h1>
            <p class="text-slate-500">Dernière mise à jour : {{ date('d F Y') }}</p>
        </div>

        <div class="prose prose-slate prose-lg max-w-none bg-white p-10 md:p-16 rounded-[3rem] border border-slate-100 shadow-xl shadow-slate-200/40">
            <p>Bienvenue sur <strong>DigitalSpace</strong>. En utilisant ce site, vous acceptez nos conditions générales d'utilisation et de vente.</p>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">1. Produits Numériques</h2>
            <p>Nos produits sont des biens numériques (articles premium, applications, documents). En raison de la nature de ces produits, aucun remboursement ne sera accordé une fois le produit téléchargé ou accédé, sauf erreur technique de notre part.</p>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">2. Propriété Intellectuelle</h2>
            <p>Tous les contenus présents sur ce site (textes, images, codes source) sont la propriété exclusive de DigitalSpace. Toute reproduction ou distribution sans autorisation est strictement interdite.</p>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">3. Responsabilité</h2>
            <p>Nous nous efforçons de fournir des informations et des outils de qualité. Cependant, DigitalSpace ne pourra être tenu responsable des dommages directs ou indirects résultant de l'utilisation de nos produits numériques.</p>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">4. Paiement</h2>
            <p>Les paiements sont effectués via Orange Money, Visa ou Mastercard. La transaction est sécurisée par nos prestataires de paiement agréés.</p>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">5. Droit Applicable</h2>
            <p>Les présentes conditions sont régies par les lois en vigueur au Burkina Faso. Tout litige sera soumis à la compétence exclusive des tribunaux de Ouagadougou.</p>

            <div class="mt-16 pt-10 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <p class="text-slate-500 text-sm italic">En utilisant nos services, vous reconnaissez avoir lu et accepté ces conditions.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-secondary transition-all shadow-lg shadow-slate-900/10">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
