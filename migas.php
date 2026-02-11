<div class="migas-pan" style="padding: 100px 10% 20px; font-size: 0.9rem; color: #00ff66; text-transform: uppercase; background: #000;">
    <a href="index.php" style="color: #00ff66; text-decoration: none; font-weight: bold;">Inicio</a> 
    <?php if (isset($pagina_actual)): ?>
        <span style="color: #555;"> > </span> 
        <span style="color: #fff;"><?php echo $pagina_actual; ?></span>
    <?php endif; ?>
    <?php if (isset($subseccion)): ?>
        <span style="color: #555;"> > </span> 
        <span style="color: #fff;"><?php echo $subseccion; ?></span>
    <?php endif; ?>
</div>