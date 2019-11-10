<?php
namespace app\Model\Config;

class Routes{
  public static function get() {
      return [
          'main' => [
              'controller' => 'main',
              'action' => 'main',
          ],
          'main/game' => [
              'controller' => 'main',
              'action' => 'game',
          ],

          '' => [
              'controller' => 'index',
              'action' => 'index',
          ],

          'account/login' => [
              'controller' => 'account',
              'action' => 'login',
          ],

          'account/register' => [
              'controller' => 'account',
              'action' => 'register',
          ],
          'account/user' => [
              'controller' => 'user',
              'action' => 'user',
          ],
      ];
  }
}
