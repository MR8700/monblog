@extends('layout.app')

@section('title', 'Politique de Confidentialité')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-20">
    <div class="space-y-12">
        <div class="text-center space-y-4">
            <h1 class="text-4xl md:text-5xl font-bold text-slate-900 leading-tight">Politique de <span class="text-primary italic font-display">Confidentialité</span></h1>
            <p class="text-slate-500">Dernière mise à jour : {{ date('d F Y') }}</p>
        </div>

        <div class="prose prose-slate prose-lg max-w-none bg-white p-10 md:p-16 rounded-[3rem] border border-slate-100 shadow-xl shadow-slate-200/40">
            <p>Chez <strong>DigitalSpace</strong>, nous accordons une importance primordiale à la protection de vos données personnelles. Cette politique détaille comment nous collectons et traitons vos informations.</p>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">1. Collecte des données</h2>
            <p>Nous collectons les informations que vous nous fournissez directement lors de vos achats ou via nos formulaires de contact :</p>
            <ul>
                <li>Nom et prénom</li>
                <li>Adresse email</li>
                <li>Numéro de téléphone</li>
                <li>Informations de paiement (traitées de manière sécurisée par nos partenaires)</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">2. Utilisation des données</h2>
            <p>Vos données sont utilisées pour :</p>
            <ul>
                <li>Traiter vos commandes et livrer vos produits numériques</li>
                <li>Améliorer nos services et votre expérience utilisateur</li>
                <li>Répondre à vos demandes de support</li>
                <li>Vous envoyer des informations importantes concernant vos achats</li>
            </ul>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">3. Protection des données</h2>
            <p>Nous utilisons des mesures de sécurité techniques et organisationnelles rigoureuses pour protéger vos données contre tout accès non autorisé, modification ou divulgation.</p>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">4. Cookies</h2>
            <p>Notre site utilise des cookies pour améliorer votre navigation et mémoriser vos préférences (comme votre panier ou vos likes).</p>

            <h2 class="text-2xl font-bold text-slate-900 mt-10">5. Vos droits</h2>
            <p>Vous disposez d'un droit d'accès, de rectification et de suppression de vos données personnelles. Pour exercer ces droits, contactez-nous à : <a href="mailto:contact@monsite.com" class="text-primary font-bold">contact@monsite.com</a>.</p>

            <div class="mt-16 pt-10 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <p class="text-slate-500 text-sm italic">Pour toute question concernant cette politique, n'hésitez pas à nous contacter.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-primary transition-all shadow-lg shadow-slate-900/10">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
