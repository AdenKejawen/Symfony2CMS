<?php

namespace CMS\System\Bundle\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CMS\System\Bundle\AdminBundle\DependencyInjection\Compiler\AddAdminsPass;

class CMSAdminBundle extends Bundle
{
   /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddAdminsPass());
    }
}
