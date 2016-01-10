<?php
/**
 * 
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * @category    Jefferson
 * @package     Jefferson_Clickview
 * @author		Jefferson Batista Porto <jefferson.b.porto@gmail.com>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */
	
	
	class Jefferson_Clickview_IndexController extends Mage_Core_Controller_Front_Action {
		
		//Carrega o layout
		public function indexAction(){
			$this->loadLayout();     
  			$this->renderLayout();
  		}
		
		//Retorna os produtos mais visualizados de uma categoria
		public function getMostViewedByCategoryAction(){
			$html = null;
			$block = $this->getLayout()->createBlock('clickview/clickviewmostviewedbycategoryblock');
			
			$getImgSize = $block->getMostViewedByCatImgSize();
			
			$cat 		= $this->getRequest()->getParam('cat');
			
			$rows 		= $block->getMostViewedByCatRow();
			
			$_products  = $block->getMostViewedByCategory($rows,$cat);
			
			foreach($_products as $item){
				
				$html .= "<li>";
				
					$html .= "<figure>";
				
						$html .= "<a href=".$item->getProductUrl() ." class='product-image'>";
							$html .= "<img src='".Mage::helper('catalog/image')->init($item, 'small_image')->keepFrame(true)->resize($getImgSize,$getImgSize)."'/>";
						$html .= "</a>";
						
						$html .= "<figcaption>";
						
							$html .= "<a href=".$item->getProductUrl() ." class='product-image'>".$item->getName()."</a>";
							$html .= $block->getPriceHtml($item, true);
							
							$html .= '<div class="product-secondary">';
									
									if(!$item->canConfigure() && $item->isSaleable()): 
										$html .= '<p class="action">';
											$html .= '<button type="button" title="'.$this->__('Add to Cart').'" class="button btn-cart" 
				                            	onclick = " setLocation('."'".$block->getAddToCartUrl($item)."'".') ">';
				                            		$html .= "<span>";
				                            			$html .= "<span>";
				                            						$html .= $this->__('Add to Cart');
				                            			$html .= "</span>";
				                            		$html .= "</span>";
				                            $html .= "</button>";
				                            	
										$html .= '</p>';
										
									elseif($item->getStockItem() && $item->getStockItem()->getIsInStock()): 
										
										$html .= '<p class="action">';
		
											$html .=  '<a title=" '.$this->__('View Details').'"
											class="button" href="'.$item->getProductUrl().' ">'.
											$this->__('View Details').'</a>';
										
										$html .= '</p>';
										
									else:
										
										$html .= '<p class="action availability out-of-stock">';
					                            	$html .= '<span>'.$this->__('Out of stock').'</span>';
					                     $html .= '</p>';
				                         
									endif;
									
							$html .= '</div>';


						$html .= "</figcaption>";
					
					$html .= "</figure>";
				
				$html .= "</li>";	
				
			}
			
			echo json_encode(array('content' => $html));
		}
		
		
		//Retorna um mesclado dos produtos mais vendidos e mais vistos de uma determinada cateoria
		public function getBestSellerByCategoryAction(){
			
			$html    	= null;
			$block   	= $this->getLayout()->createBlock('clickview/clickviewbestsellerbycategoryblock');
			$cat     	= $this->getRequest()->getParam('cat');
			$rows    	= $block->getBestSellerByCatRow();
			$imgSize   	= $block->getBestSellerByCatImgSize();
			$_products 	= $block->getBestsellerProductsByCategory($rows,$cat);
			
			foreach($_products as $item){
				
				$html .= "<li>";
				
					$html .= "<figure>";
				
						$html .= "<a href=".$item->getProductUrl() ." class='product-image'>";
							$html .= "<img src='".Mage::helper('catalog/image')->init($item, 'small_image')->keepFrame(true)->resize($imgSize,$imgSize)."'/>";
						$html .= "</a>";
						
						$html .= "<figcaption>";
							$html .= "<a href=".$item->getProductUrl() ." class='product-image'>".$item->getName()."</a>";
							$html .= $block->getPriceHtml($item, true);
							
							$html .= '<div class="product-secondary">';
									
									if(!$item->canConfigure() && $item->isSaleable()): 
										$html .= '<p class="action">';
											$html .= '<button type="button" title="'.$this->__('Add to Cart').'" class="button btn-cart" 
				                            	onclick = " setLocation('."'".$block->getAddToCartUrl($item)."'".') ">';
				                            		$html .= "<span>";
				                            			$html .= "<span>";
				                            						$html .= $this->__('Add to Cart');
				                            			$html .= "</span>";
				                            		$html .= "</span>";
				                            $html .= "</button>";
				                            	
										$html .= '</p>';
										
									elseif($item->getStockItem() && $item->getStockItem()->getIsInStock()): 
										
										$html .= '<p class="action">';
		
											$html .=  '<a title=" '.$this->__('View Details').'"
											class="button" href="'.$item->getProductUrl().' ">'.
											$this->__('View Details').'</a>';
										$html .= '</p>';
									else:
										
										$html .= '<p class="action availability out-of-stock">';
					                            	$html .= '<span>'.$this->__('Out of stock').'</span>';
					                         $html .= '</p>';
				                            	
										$html .= '</p>';
										
									endif;
									
							$html .= '</div>';

						$html .= "</figcaption>";
					
					$html .= "</figure>";
				
				$html .= "</li>";	
				
			}
			
			echo json_encode(array('content' => $html));
			
		}
		
		public function getProductsNewsByCategoryAction(){
			
			$html    = null;	
			$block   = $this->getLayout()->createBlock('clickview/clickviewnewsproductsblock');
			$cat     = $this->getRequest()->getParam('cat');
			$rows    = $block->getNewProductByCatRow();
			$imgSize = $block->getNewProductByCatImgSize();
			
			
			$_products = $block->getNewsProductCollectionByCategory($rows,$cat);
			
			foreach($_products as $item){
				
				$html .= "<li>";
				
					$html .= "<figure>";
				
						$html .= "<a href=".$item->getProductUrl() ." class='product-image'>";
							$html .= "<img src='".Mage::helper('catalog/image')->init($item, 'small_image')->keepFrame(true)->resize($imgSize,$imgSize)."'/>";
						$html .= "</a>";
						
						$html .= '<span class="perc">'.$this->__('News').'</span>';
					    
						$html .= "<figcaption>";
						
							$html .= "<a href=".$item->getProductUrl() ." class='product-image'>".$item->getName()."</a>";
							$html .= $block->getPriceHtml($item, true);
							
							$html .= '<div class="product-secondary">';
									
									if(!$item->canConfigure() && $item->isSaleable()): 
										$html .= '<p class="action">';
											$html .= '<button type="button" title="'.$this->__('Add to Cart').'" class="button btn-cart" 
				                            	onclick = " setLocation('."'".$block->getAddToCartUrl($item)."'".') ">';
				                            		$html .= "<span>";
				                            			$html .= "<span>";
				                            						$html .= $this->__('Add to Cart');
				                            			$html .= "</span>";
				                            		$html .= "</span>";
				                            $html .= "</button>";
				                            	
										$html .= '</p>';
										
									elseif($item->getStockItem() && $item->getStockItem()->getIsInStock()): 
										
										$html .= '<p class="action">';
		
											$html .=  '<a title=" '.$this->__('View Details').'"
											class="button" href="'.$item->getProductUrl().' ">'.
											$this->__('View Details').'</a>';
										$html .= '</p>';
									else:
										
										$html .= '<p class="action availability out-of-stock">';
					                            	$html .= '<span>'.$this->__('Out of stock').'</span>';
					                         $html .= '</p>';
				                            	
										$html .= '</p>';
										
									endif;
									
							$html .= '</div>';
							 
							 
						$html .= "</figcaption>";
					
					$html .= "</figure>";
				
				$html .= "</li>";	
				
			}
			
			echo json_encode(array('content' => $html));

		}
		
		
		public function getAllProductsPromotionAction(){
			
			$html 		= null;
			
			$block 		= $this->getLayout()->createBlock('clickview/Clickviewproductspromotionblock');
			
			$cat  		= $this->getRequest()->getParam('cat');
			
			$num 		= $block->getNewProductByCatRow();
			
			$imgSize 	= $block->getNewProductByCatImgSize(); 
			
			$_products  = $block->getAllProductsPromotion($num, $cat);
			
			foreach($_products as $item){
				
				$html .= "<li>";
				
					$html .= "<figure>";
				
						$html .= "<a href=".$item->getProductUrl() ." class='product-image'>";
							$html .= "<img src='".Mage::helper('catalog/image')->init($item, 'small_image')->keepFrame(true)->resize($imgSize,$imgSize)."'/>";
						$html .= "</a>";
						
						if($item->getSpecialPrice() > 0 ): 
							     $html .= '<span class="perc">'.$block->getPerc($item->getPrice(), $item->getSpecialPrice() ).'</span>';
					    endif; 
						
						$html .= "<figcaption>";
						
							$html .= "<a href=".$item->getProductUrl() ." class='product-image'>".$item->getName()."</a>";
							$html .= $block->getPriceHtml($item, true);
							
							$html .= '<div class="product-secondary">';
									
									if(!$item->canConfigure() && $item->isSaleable()): 
										$html .= '<p class="action">';
											$html .= '<button type="button" title="'.$this->__('Add to Cart').'" class="button btn-cart" 
				                            	onclick = " setLocation('."'".$block->getAddToCartUrl($item)."'".') ">';
				                            		$html .= "<span>";
				                            			$html .= "<span>";
				                            						$html .= $this->__('Add to Cart');
				                            			$html .= "</span>";
				                            		$html .= "</span>";
				                            $html .= "</button>";
				                            	
										$html .= '</p>';
										
									elseif($item->getStockItem() && $item->getStockItem()->getIsInStock()): 
										
										$html .= '<p class="action">';
		
											$html .=  '<a title=" '.$this->__('View Details').'"
											class="button" href="'.$item->getProductUrl().' ">'.
											$this->__('View Details').'</a>';
										$html .= '</p>';	
									else:
										
										$html .= '<p class="action availability out-of-stock">';
					                            	$html .= '<span>'.$this->__('Out of stock').'</span>';
					                         $html .= '</p>';
				                            	
										$html .= '</p>';
										
									endif;
									
							$html .= '</div>';

							
						$html .= "</figcaption>";
					
					$html .= "</figure>";
				
				$html .= "</li>";	
				
			}
			
			echo json_encode(array('content' => $html));		
							
		}
		
		
		public function getCatAction(){
			$html = null;
			$storeId    = Mage::app()->getStore()->getId();
 		
	 		$catAllowed = self::getCategoryAllowed();
	 		
	 		$cat  		= Mage::getSingleton('catalog/category')
	 						->getCollection()
	 						->addAttributeToSelect('*')
	 						->setStoreId($storeId)
	 						->addAttributeToFilter('entity_id', array('in' => $catAllowed));
	 		
	 		foreach($cat as $i){
	 			$html .=  "<option value='".$i->getId()."'>".$i->getName()."</option>";
	 		}
	 		
	 		
		}
		
		public function getCategoryAllowed(){
	 		$cat = explode(',', Mage::getStoreConfig('clickview_by_category/clickview_most_viewed_by_category/clickview_category_allowed'));
	 		return $cat;
	 	}
		
		
		/**public function feedAction(){
			
			$_products = Mage::getSingleton('catalog/product')
			->getCollection()
			->addAttributeToSelect('*')
			->addAttributeToFilter('status', array('eq' => 1))
			->joinField('qty',
                 'cataloginventory/stock_item',
                 'qty',
                 'product_id=entity_id',
                 '{{table}}.stock_id=1',
                 'left')
            
     		->addAttributeToFilter('qty', array("gt" => 0))
			->load();
			
			$xml .= '<?xml version="1.0"?>';
				$xml .= '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">';
					$xml .= '<channel>';
						$xml .= '<title>Hajime</title>';
						$xml .=	'<link>http://webmaster.hajimesushitucuruvi.com.br/teste/</link>';
						$xml .= '<description>Loja teste</description>';
			
			foreach($_products as $item){
				
							$xml .= '<item>';
									$xml .= "<g:id>".$item->getSku()."</g:id>";
									$xml .= "<g:title>".$item->getName()."</g:title>";
									$xml .= "<g:description>".$item->getShortDescription()."</g:description>";
									$xml .= "<g:price>".self::getPriceProduct($item->getPrice(), $item->getSpecialPrice())."</g:price>";
									$xml .= "<g:availability>".self::isStock($item->isSaleable())."</g:availability>";
									$xml .= "<g:link>".$item->getProductUrl()."</g:link>";
									$xml .= "<g:image_link>".Mage::helper('catalog/image')->init($item, 'small_image')->resize(200)."</g:image_link>";
									$xml .= "<g:condition>new</g:condition>";
									$xml .= "".number_format($item->getQty(),0,'','')."";
									$xml .= '<g:shipping>
												<g:country>BR</g:country>
												<g:service>Standard</g:service>
												<g:price>20.00 BRL</g:price>
											</g:shipping>';
									$xml .= "<g:google_product_category>Alimentos, bebidas e tabaco > Alimentos > Padaria</g:google_product_category>";
									$xml .= '<g:identifier_exists>FALSE</g:identifier_exists>';
									$xml .= "<g:product_type>Alimentos Orgânicos</g:product_type>";
							$xml .= '</item>';	
				
			}
			
					$xml .= '</channel>';	
				$xml .= '</rss>';
			
			return  self::setFile($xml);
			
		}*/
		
		public function isStock($stock){
			if($stock){
				return "in stock";
			}else{
				return "sold out";
			}
		}
		
		public function getPriceProduct($price, $specialPrice){
			if($specialPrice > 0){
				return number_format($specialPrice,2,'.','.');
			}else{
				return number_format($price,2,'.','.');
			}
		}
		
		public function setFile($xml){
			$f = fopen('feed.xml', 'a+');
			fwrite($f, $xml);
			fclose($f);
		}
		
	}
	
?>