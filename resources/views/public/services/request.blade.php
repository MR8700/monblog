@extends('layout.app')

@section('title', 'Demande de Service - DigitalSpace')

@section('content')
<section class="max-w-4xl mx-auto px-6 py-12">
    <div class="flex flex-col gap-12">
        <div class="text-center space-y-4">
            <h1 class="text-5xl font-black text-slate-900 tracking-tight">Besoin d'un <span class="text-primary italic">Service ?</span></h1>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto font-medium">Graphisme, e-concours, e-timbre... Décrivez votre projet et nos experts vous accompagneront de A à Z.</p>
        </div>

        <form action="{{ route('services.request.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ fields: [] }">
            @csrf
            
            <!-- Informations Personnelles -->
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-xl shadow-slate-200/40 space-y-8">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-user-circle text-primary"></i> Vos Informations
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Nom complet</label>
                        <input type="text" name="client_name" required class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Email</label>
                        <input type="email" name="client_email" required class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Téléphone / WhatsApp</label>
                        <input type="text" name="client_phone" required class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Type de Service</label>
                        <select name="service_type" required class="w-full bg-slate-50 border-transparent rounded-2xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-bold text-slate-700">
                            @foreach($serviceTypes as $type)
                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                            @endforeach
                            <option value="Autre">Autre (préciser dans la description)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Détails du Projet -->
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 shadow-xl shadow-slate-200/40 space-y-8">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-3">
                    <i class="fas fa-pen-nib text-primary"></i> Détails du Projet
                </h2>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Description détaillée</label>
                    <textarea name="description" rows="5" required class="w-full bg-slate-50 border-transparent rounded-3xl px-6 py-4 focus:bg-white focus:ring-4 focus:ring-primary/5 transition-all font-medium" placeholder="Expliquez-nous votre besoin, vos contraintes, vos préférences..."></textarea>
                </div>

                <!-- Champs Personnalisés (Alpine.js) -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Informations Complémentaires</label>
                        <button type="button" @click="fields.push({label: '', value: ''})" class="text-xs font-bold text-primary hover:underline">
                            + Ajouter un champ
                        </button>
                    </div>
                    <template x-for="(field, index) in fields" :key="index">
                        <div class="flex gap-4 items-end">
                            <div class="flex-1 space-y-1">
                                <input type="text" :name="'custom_fields['+index+'][label]'" x-model="field.label" placeholder="Libellé (ex: Date de l'évènement)" class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-2 text-sm">
                            </div>
                            <div class="flex-1 space-y-1">
                                <input type="text" :name="'custom_fields['+index+'][value]'" x-model="field.value" placeholder="Valeur" class="w-full bg-slate-50 border-transparent rounded-xl px-4 py-2 text-sm">
                            </div>
                            <button type="button" @click="fields.splice(index, 1)" class="w-10 h-10 rounded-xl bg-red-50 text-red-500 flex items-center justify-center">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>

                <!-- Pièces Jointes -->
                <div class="space-y-2 pt-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-4">Fichiers & Images (Max 20MB/fichier)</label>
                    <div class="relative group">
                        <input type="file" name="attachments[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="border-2 border-dashed border-slate-200 rounded-3xl p-12 text-center group-hover:border-primary/50 group-hover:bg-primary/5 transition-all">
                            <i class="fas fa-cloud-upload-alt text-4xl text-slate-300 mb-4 group-hover:text-primary transition-colors"></i>
                            <p class="text-slate-500 font-medium">Cliquez ou déposez vos fichiers ici</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-2">Images haute résolution, PDF, etc.</p>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white rounded-[2rem] py-6 font-black text-xl hover:bg-primary transition-all shadow-2xl shadow-slate-900/20">
                Soumettre ma demande
            </button>
        </form>
    </div>
</section>
@endsection
