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
                          'controller'=>'index',
                          'action'=>'index'
                      )
                  )
              ),
              
              'stick'=>array(
                  'type'=>'Literal',
                   'options'=>array(
                       'route'=>'/stick',
                       'constraints'=>array(
                          'id'    =>'[0-9]+'
                       ),
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
                        ),
                  
               ) 

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
            
        ),
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
);
