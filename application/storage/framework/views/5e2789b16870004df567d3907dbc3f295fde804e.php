<?php $__env->startSection('title', 'HomeCare'); ?>

<?php $__env->startSection('search-label', 'Pesquisar pacientes'); ?>
<?php $__env->startSection('data-search', 'pacientes'); ?>

<?php $__env->startSection('btn-add-title','Adicionar paciente'); ?>
<?php $__env->startSection('btn-add-icon', 'person_add_alt_1'); ?>
<?php $__env->startSection('btn-add-route', go('clinica.pacientes.add')); ?>

<?php $__env->startSection('total-results'); ?>
<?php echo e($pacientes->total()); ?> registro<?php echo e((($pacientes->total()>1) ? 's' : null)); ?>

<ul id="dropdown-registros" class="dropdown-content">
	<li><a data-url="<?php echo e(go('clinica.pacientes.index')); ?>" class="active">Todos</a></li>
	
	<li><a data-url="<?php echo e(go('clinica.pacientes.index')); ?>?status=1&obito=0">Ativos</a></li>
	<li><a data-url="<?php echo e(go('clinica.pacientes.index')); ?>?status=0&obito=0">Inativos</a></li>
	
	<li><a data-url="<?php echo e(go('clinica.pacientes.index')); ?>?obito=0">Vivos</a></li>
	<li><a data-url="<?php echo e(go('clinica.pacientes.index')); ?>?status=0&obito=1">Falecidos</a></li>
</ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('container'); ?>
<?php echo $__env->make('clinica.pacientes.results', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('left-sidebar'); ?>
<?php echo $__env->make('clinica.agendamentos.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('clinica.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alissonp/www/cliniccloud-main/application/resources/views/clinica/homecare/index.blade.php ENDPATH**/ ?>