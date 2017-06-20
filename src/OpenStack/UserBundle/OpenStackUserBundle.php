<?php

namespace OpenStack\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class OpenStackUserBundle extends Bundle
{
  public function getParent()
  {
    return 'FOSUserBundle';
  }
}
