<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            
             'home'=>array(
                  'type'=>'Literal',
                  'options'=>array(
                      'route'=>'/',
                      'defaults'=>array(
                          'controller'=>'stick',
                          'action'=>'list',
                          'type'=>'hot'
                      )
                  )
              ),
              'best'=>array(
                  'type'=>'Literal',
                  'options'=>array(
                      'route'=>'/best',
                      'defaults'=>array(
                          'controller'=>'stick',
                          'action'=>'list',
                          'type'=>'best'
                      ),
                    
                  )
              ),
              'new'=>array(
                  'type'=>'Literal',
                  'options'=>array(
                      'route'=>'/new',
                      'defaults'=>array(
                          'controller'=>'stick',
                          'action'=>'list',
                          'type'=>'new'
                      ),
                      
                  )
              ),
              'stick'=>array(
                  'type'=>'Literal',
                   'options'=>array(
                       'route'=>'/stick',
                       'defaults'=>array(
                           //'__NAMESPACE__'=>'Sticks\Controller',
                           'action'=>'add',
                           'controller'=>'stick'
                       )
                     ),
                     'may_terminate'=>true,
                     'child_routes' => array(
                            'show' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/:id',
                                    'constraints' => array(
                                       'id'=>'[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller'=>'stick',
                                        'action'=>'show'
                                    ),
                                ),
                            ),
                           'def' =>array(
                               'type'=>'Segment',
                               'options'=>array(
                                   'route'=>'/:action',
                                   'constraints'=>array(
                                       'action'=>'[a-zA-Z]+'
                                   ),
                                   'default'=>array(
                                       'controller'=>'stick'
                                   )
                               )
                           )
                        ),
                  
               ),
             'login'=>array(
                 'type'=>'Literal',
                 'options'=>array(
                     'route'=>'/login',
                     'defaults'=>array(
                         'controller'=>'auth',
                         'action'=>'login'
                     )
                 )
             ),
            'signup'=>array(
                 'type'=>'Literal',
                 'options'=>array(
                     'route'=>'/signup',
                     'defaults'=>array(
                         'controller'=>'auth',
                         'action'=>'signup'
                     )
                 )
             ),
            'confirm'=>array(
                'type'=>'Literal',
                 'options'=>array(
                     'route'=>'/confirm',
                     'defaults'=>array(
                         'controller'=>'auth',
                         'action'=>'confirm'
                     )
                 ) 
            ),
             'logout'=>array(
                 'type'=>'Literal',
                 'options'=>array(
                     'route'=>'/logout',
                     'defaults'=>array(
                         'controller'=>'auth',
                         'action'=>'logout'
                     )
                 )
             ),

        ),
    ),
    
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        
        'invokables' => array(
            'index' => 'Sticks\Controller\Index',
            'stick' =>'Sticks\Controller\Stick',
            'auth' =>'Sticks\Controller\Auth',
            
        ),
        
    ),
    'controller_plugins' => array(
        'invokables' => array(
           'auth' => '\Sticks\Plugin\AuthPlugin',
         )
     ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'stick/index/index' => __DIR__ . '/../view/stick/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(  
            'invokables' => array(  
                 'stick' => 'Sticks\Helper\Stick',
                 'user' => 'Sticks\Helper\User', 
             ),  
       ),
    
);
