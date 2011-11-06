<?php

namespace CMS\System\Bundle\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CMS\System\Bundle\AdminBundle\DependencyInjection\Compiler\AddAdminsPass;
use CMS\System\Bundle\AdminBundle\DependencyInjection\Compiler\AdminActionPass;
use CMS\System\Bundle\AdminBundle\DependencyInjection\Compiler\AddAdminRoutePass;

class CMSAdminBundle extends Bundle
{
   /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddAdminsPass());
        $container->addCompilerPass(new AdminActionPass());
        $container->addCompilerPass(new AddAdminRoutePass());
    }
}
