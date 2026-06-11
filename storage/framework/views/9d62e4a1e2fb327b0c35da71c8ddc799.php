<?php if (isset($component)) { $__componentOriginalaa758e6a82983efcbf593f765e026bd9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa758e6a82983efcbf593f765e026bd9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::message'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
# <?php echo new \Illuminate\Support\EncodedHtmlString($type === 'admin' ? 'Nouvelle Demande de Service' : 'Confirmation de Demande'); ?>


Bonjour <?php echo new \Illuminate\Support\EncodedHtmlString($type === 'admin' ? 'Administrateur' : $serviceRequest->client_name); ?>,

<?php echo new \Illuminate\Support\EncodedHtmlString($type === 'admin' 
    ? "Une nouvelle demande de service a été soumise sur DigitalSpace." 
    : "Nous avons bien reçu votre demande de service et nous vous remercions de votre confiance."); ?>


## Récapitulatif de la demande :
- **Type de service :** <?php echo new \Illuminate\Support\EncodedHtmlString($serviceRequest->service_type); ?>

- **Client :** <?php echo new \Illuminate\Support\EncodedHtmlString($serviceRequest->client_name); ?>

- **Email :** <?php echo new \Illuminate\Support\EncodedHtmlString($serviceRequest->client_email); ?>

- **Téléphone :** <?php echo new \Illuminate\Support\EncodedHtmlString($serviceRequest->client_phone); ?>


**Description :**
<?php echo new \Illuminate\Support\EncodedHtmlString($serviceRequest->description); ?>


<?php if($serviceRequest->custom_fields && count($serviceRequest->custom_fields) > 0): ?>
**Informations complémentaires :**
<?php $__currentLoopData = $serviceRequest->custom_fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
- **<?php echo new \Illuminate\Support\EncodedHtmlString($field['label']); ?> :** <?php echo new \Illuminate\Support\EncodedHtmlString($field['value']); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if($type === 'admin'): ?>
<?php if (isset($component)) { $__componentOriginal15a5e11357468b3880ae1300c3be6c4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15a5e11357468b3880ae1300c3be6c4f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::button'),'data' => ['url' => route('admin.services.show', $serviceRequest->id)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.services.show', $serviceRequest->id))]); ?>
Voir la demande sur le panel
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal15a5e11357468b3880ae1300c3be6c4f)): ?>
<?php $attributes = $__attributesOriginal15a5e11357468b3880ae1300c3be6c4f; ?>
<?php unset($__attributesOriginal15a5e11357468b3880ae1300c3be6c4f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal15a5e11357468b3880ae1300c3be6c4f)): ?>
<?php $component = $__componentOriginal15a5e11357468b3880ae1300c3be6c4f; ?>
<?php unset($__componentOriginal15a5e11357468b3880ae1300c3be6c4f); ?>
<?php endif; ?>
<?php else: ?>
Nous reviendrons vers vous très prochainement par email ou WhatsApp pour discuter des détails de votre projet.
<?php endif; ?>

Merci,<br>
L'équipe <?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $attributes = $__attributesOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $component = $__componentOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__componentOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?>
<?php /**PATH /var/www/monblog/resources/views/emails/service-request-notification.blade.php ENDPATH**/ ?>