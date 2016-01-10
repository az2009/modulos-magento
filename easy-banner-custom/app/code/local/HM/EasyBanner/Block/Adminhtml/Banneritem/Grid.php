<?php

class HM_EasyBanner_Block_Adminhtml_Banneritem_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('easybanneritemGrid');
      $this->setDefaultSort('banner_item_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('easybanner/banneritem')->getCollection()->setOrder('banner_id','DESC')->setOrder('banner_order','ASC');
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	  $this->setTemplate('easybanner/grid.phtml');
      $this->addColumn('banner_item_id', array(
          'header'    => Mage::helper('easybanner')->__('ID'),
          'align'     =>'right',
          'type'	  => 'number',
          'width'     => '50px',
          'index'     => 'banner_item_id',
      ));

	  $banners = array();
	  $collection = Mage::getModel('easybanner/banner')->getCollection();
	  foreach ($collection as $banner) {
		 $banners[$banner->getId()] = $banner->getTitle();
	  }
	  
	  $this->addColumn('banner_id', array(
          'header'    => Mage::helper('easybanner')->__('Banner'),
          'align'     =>'left',
          'index'     => 'banner_id',
		  'type'      => 'options',
          'options'   => $banners,
      ));


	  $this->addColumn('image',
			array(
				'header'=> Mage::helper('easybanner')->__('Image'),
				'type'  => 'image',
				'width' => 64,
				'index' => 'image',
				'filter' => false,
				'renderer'  => 'HM_EasyBanner_Block_Adminhtml_Banneritem_Grid_Renderer_Image',
		));
	 
	  $this->addColumn('item_active_from',
			array(
				'header'=> Mage::helper('easybanner')->__('De'),
				'type'  => 'date',
				'width' => 64,
				'index' => 'item_active_from',
		));
		
	  $this->addColumn('item_active_to',
			array(
				'header'=> Mage::helper('easybanner')->__('Até'),
				'type'  => 'date',
				'width' => 64,
				'index' => 'item_active_to',
		));		

      $this->addColumn('title', array(
          'header'    => Mage::helper('easybanner')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

      $this->addColumn('link_url', array(
          'header'    => Mage::helper('easybanner')->__('Url'),
          'align'     =>'left',
          'index'     => 'link_url',
      ));
      
 	  $this->addColumn('banner_order', array(
          'header'    => Mage::helper('easybanner')->__('Order'),
          'align'     =>'left',
 	  	  'width' 	  => 64,
 	  	  'type'	  => 'number',
          'index'     => 'banner_order',
      ));
	  
      $this->addColumn('status', array(
		  'header'    => Mage::helper('easybanner')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('easybanner')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('easybanner')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('easybanner')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('easybanner')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('banner_item_id');
        $this->getMassactionBlock()->setFormFieldName('easybanneritem');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('easybanner')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('easybanner')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('easybanner/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('easybanner')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('easybanner')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}