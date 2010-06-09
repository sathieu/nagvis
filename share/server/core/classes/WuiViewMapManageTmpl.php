<?php
/*****************************************************************************
 *
 * WuiViewMapManageTmpl.php - Class to render the map template management page
 *
 * Copyright (c) 2004-2010 NagVis Project (Contact: info@nagvis.org)
 *
 * License:
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 2 as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
 *
 *****************************************************************************/
 
/**
 * @author	Lars Michelsen <lars@vertical-visions.de>
 */
class WuiViewMapManageTmpl {
	private $CORE;
	private $AUTHENTICATION;
	private $AUTHORISATION;
	private $aOpts = null;
	
	/**
	 * Class Constructor
	 *
	 * @param 	GlobalCore 	$CORE
	 * @author 	Lars Michelsen <lars@vertical-visions.de>
	 */
	public function __construct(CoreAuthHandler $AUTHENTICATION, CoreAuthorisationHandler $AUTHORISATION) {
		$this->CORE = GlobalCore::getInstance();
		$this->AUTHENTICATION = $AUTHENTICATION;
		$this->AUTHORISATION = $AUTHORISATION;
	}

	/**
	 * Setter for the options array
	 *
	 * @param   Array   Array of options
	 * @author  Lars Michelsen <lars@vertical-visions.de>
	 */
	public function setOpts($a) {
		$this->aOpts = $a;
	}
	
	/**
	 * Parses the information in html format
	 *
	 * @return	String 	String with Html Code
	 * @author 	Lars Michelsen <lars@vertical-visions.de>
	 */
	public function parse() {
		// Initialize template system
		$TMPL = New CoreTemplateSystem($this->CORE);
		$TMPLSYS = $TMPL->getTmplSys();
		
		// Read map configig but don't resolve tempaltes
		$MAPCFG = new WuiMapCfg($this->CORE, $this->aOpts['show']);
		$MAPCFG->readMapConfig(0, false, false);
		
		$aData = Array(
			'htmlBase' => $this->CORE->getMainCfg()->getValue('paths', 'htmlbase'),
			'map' => $this->aOpts['show'],
			'langTmplAdd' => $this->CORE->getLang()->getText('Create Template'),
			'langTmplName' => $this->CORE->getLang()->getText('Name'),
			'langTmplAddOption' => $this->CORE->getLang()->getText('Add Option'),
			'langTmplDoAdd' => $this->CORE->getLang()->getText('Add'),
			'langTmplModify' => $this->CORE->getLang()->getText('Modify Template'),
			'langTmplDoModify' => $this->CORE->getLang()->getText('Modify'),
			'langTmplDelete' => $this->CORE->getLang()->getText('Delete Template'),
			'langTmplChoose' => $this->CORE->getLang()->getText('Name'),
			'langTmplDoDelete' => $this->CORE->getLang()->getText('Delete'),
			'templates' => $MAPCFG->getTemplateNames(),
		);
		
		// Build page based on the template file and the data array
		return $TMPLSYS->get($TMPL->getTmplFile('default', 'wuiMapManageTmpl'), $aData);
	}
}
?>