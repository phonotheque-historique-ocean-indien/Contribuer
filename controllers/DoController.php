<?php
    /* ----------------------------------------------------------------------
     * simpleListEditor
     * ----------------------------------------------------------------------
     * List & list values editor plugin for Providence - CollectiveAccess
     * Open-source collections management software
     * ----------------------------------------------------------------------
     *
     * Plugin by idéesculture (www.ideesculture.com)
     * This plugin is published under GPL v.3. Please do not remove this header
     * and add your credits thereafter.
     *
     * File modified by :
     * ----------------------------------------------------------------------
     */

    require_once(__CA_MODELS_DIR__.'/ca_lists.php');
    require_once(__CA_MODELS_DIR__.'/ca_list_items.php');
    require_once(__CA_MODELS_DIR__.'/ca_objects.php');
    require_once(__CA_MODELS_DIR__.'/ca_object_labels.php');
    require_once(__CA_LIB_DIR__."/core/Plugins/PDFRenderer/PhantomJS.php");
	error_reporting(E_ERROR);

 	class DoController extends ActionController {
 		# -------------------------------------------------------
  		protected $opo_config;		// plugin configuration file
        protected $opa_list_of_lists; // list of lists
        protected $opa_listIdsFromIdno; // list of lists
        protected $opa_locale; // locale id
		private $opo_list;
 		# -------------------------------------------------------
 		# Constructor
 		# -------------------------------------------------------

 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
            parent::__construct($po_request, $po_response, $pa_view_paths);

 			$this->opo_config = Configuration::load(__CA_APP_DIR__.'/plugins/Contribuer/conf/contribuer.conf');
 			
			$this->opo_list = new ca_lists("object_types");
        }

 		# -------------------------------------------------------
 		# Functions to render views
 		# -------------------------------------------------------
 		public function Add($type="") {
 			$id= $this->request->getParameter("id", pInteger);
			$this->view->setVar("template", $this->opo_config->get("template"));
            $this->view->setVar("mappings", $this->opo_config->get("mappings"));
            $this->render('index_html.php');
 		}

 		public function Create() {
 		    // TODO : test if already exist
            // - isbn
            // - title & author & date

            $vt_object = new ca_objects();
            $vt_object->setMode(ACCESS_WRITE); //Set access mode to WRITE
            $pn_locale_id='1'; //Set the locale
            $vt_object->set(array('access' => 1, 'status' => 3, 'idno' => "test",'type_id' => $this->opo_config->get("type_id"),'locale_id'=>$pn_locale_id));//Define some intrinsic data.
            $id = $vt_object->insert();//Insert the object
            if(!$id) {
                //var_dump($vt_object->getErrors());
                $id= $this->request->getParameter("id", pInteger);
                $this->view->setVar("template", $this->opo_config->get("template"));
                $this->view->setVar("mappings", $this->opo_config->get("mappings"));
                $this->view->setVar("errors", $vt_object->getErrors());
                $this->render('index_html.php');
            } else {
                var_dump($_POST);
                var_dump($id);
                die();

            }
        }

        public function Additions() {

        }

        public function Review() {

        }

 	}
 ?>
