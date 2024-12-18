<?php /*<base href="/akila-project/akila.blog_new/core/core11/"> */ ?>
<!-- <base href="https://akila.blog/core/core11/"> -->

<style> 
    :root{
        --primary: <?= (!empty($couleur_entreprise1)) ? $couleur_entreprise1 : '#d41640';?>;
        --tersiery: <?= (!empty($couleur_entreprise2)) ? $couleur_entreprise2 : '#ffffff';?>;
    }

    .color_deux{
        color:var(--tersiery) !important;
    }

</style> 