<?php
/** SportsManagement ein Programm zur Verwaltung für alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: © 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
* @license                This file is part of SportsManagement.
*
* SportsManagement is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* SportsManagement is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with SportsManagement.  If not, see <http://www.gnu.org/licenses/>.
*
* Diese Datei ist Teil von SportsManagement.
*
* SportsManagement ist Freie Software: Sie können es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder späteren
* veröffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es nützlich sein wird, aber
* OHNE JEDE GEWÄHELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gewährleistung der MARKTFÄHIGKEIT oder EIGNUNG FÜR EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License für weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 

/**
 * sportsmanagementControllerpredictionmembers
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementControllerpredictionmembers extends JControllerAdmin
{
    
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JControllerLegacy
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
        
        // Reference global application object
        $this->jsmapp = JFactory::getApplication();
        // JInput object
        $this->jsmjinput = $this->jsmapp->input;


	}    
    
    /**
     * sportsmanagementControllerpredictionmembers::save_memberlist()
     * 
     * @return void
     */
    function save_memberlist()
    {
    	
        // Check for request forgeries
		JRequest::checkToken() or die('JINVALID_TOKEN');

        $model = $this->getModel();
       $msg = $model->save_memberlist();
        $this->setRedirect('index.php?option=com_sportsmanagement&view=close&tmpl=component',$msg);    
        
        
    }
    
    /**
     * sportsmanagementControllerpredictionmembers::editlist()
     * 
     * @return void
     */
    function editlist()
	{
	   $msg		= '';
       $link = 'index.php?option=com_sportsmanagement&view=predictionmembers&layout=editlist';
		//echo $msg;
		$this->setRedirect( $link, $msg );
       
    }
       
	/**
	 * sportsmanagementControllerpredictionmembers::sendReminder()
	 * 
	 * @return void
	 */
	function reminder()
	{
//	   // Reference global application object
//        $this->jsmapp = JFactory::getApplication();
//        // JInput object
//        $this->jsmjinput = $this->jsmapp->input;
        
//		JToolBarHelper::title( JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_PMEMBER_CTRL_SEND_REMINDER_MAIL' ), 'generic.png' );
//		JToolBarHelper::back( 'COM_SPORTSMANAGEMENT_ADMIN_PMEMBER_CTRL_BACK', 'index.php?option=com_sportsmanagement&view=predictionmembers' );

//		echo 'This will send an email to all members of the prediction game with reminder option enabled. Are you sure?';
		//$post = JRequest::get( 'post' );
        $post = $this->jsmjinput->post->getArray();
//        $this->jsmapp->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' post<br><pre>'.print_r($post,true).'</pre>'),'Notice');
        
		//$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );
        $cid = $this->jsmjinput->getVar('cid', null, 'post', 'array');
//        $this->jsmapp->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' cid<br><pre>'.print_r($cid,true).'</pre>'),'Notice');
        
		$pgmid = JRequest::getVar( 'prediction_id', 0, 'post', 'INT' );
//        $this->jsmapp->enqueueMessage(JText::_(__METHOD__.' '.__LINE__.' pgmid<br><pre>'.print_r($pgmid,true).'</pre>'),'Notice');
//		$post['id'] = (int) $cid[0];
//		$post['predgameid'] = (int) $pgmid[0];
//		echo '<pre>'; print_r($post); echo '</pre>';


		if ( $pgmid == 0 )
		{
			JError::raiseWarning( 500, JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_PMEMBER_CTRL_SELECT_ERROR' ) );
		}
		$msg		= '';
		$d			= ' - ';

		$model = $this->getModel( 'predictionmember' );
    $model->sendEmailtoMembers($cid,$pgmid);

		$link = 'index.php?option=com_sportsmanagement&view=predictionmembers';
		//echo $msg;
		$this->setRedirect( $link, $msg );
	}
    
    
    
    /**
     * sportsmanagementControllerpredictionmembers::publish()
     * 
     * @return void
     */
    function publish()
	{
		$cids = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cids );
		$predictionGameID	= JRequest::getVar( 'prediction_id', '', 'post', 'int' );

		if ( count( $cids ) < 1 )
		{
			JError::raiseError( 500, JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_PMEMBER_CTRL_SEL_MEMBER_APPR' ) );
		}

		$model = $this->getModel( 'predictionmember' );
		if( !$model->publishpredmembers( $cids, 1, $predictionGameID ) )
		{
			echo "<script> alert( '" . $model->getError(true) . "' ); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_sportsmanagement&view=predictionmembers' );
	}
    
    
    /**
     * sportsmanagementControllerpredictionmembers::unpublish()
     * 
     * @return void
     */
    function unpublish()
	{
		$cids = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cids );
		$predictionGameID	= JRequest::getVar( 'prediction_id', '', 'post', 'int' );

		if ( count( $cids ) < 1 )
		{
			JError::raiseError( 500, JText::_( 'COM_SPORTSMANAGEMENT_ADMIN_PMEMBER_CTRL_SEL_MEMBER_REJECT' ) );
		}

		$model = $this->getModel( 'predictionmember' );
		if ( !$model->publishpredmembers( $cids, 0, $predictionGameID ) )
		{
			echo "<script> alert( '" . $model->getError(true)  ."' ); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_sportsmanagement&view=predictionmembers' );
	}
    
    
    /**
     * sportsmanagementControllerpredictionmembers::remove()
     * 
     * @return void
     */
    function remove()
	{
		// Reference global application object
        $app = JFactory::getApplication();
        // JInput object
        $jinput = $app->input;
        $option = $jinput->getCmd('option');
    
		$d		= ' - ';
		$msg	= '';
		$cid	= JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		$prediction_id	= JRequest::getInt('prediction_id',(-1),'post');
		//echo '<pre>'; print_r($cid); echo '</pre>';

		if (count($cid) < 1)
		{
			JError::raiseError(500,JText::_('COM_SPORTSMANAGEMENT_ADMIN_PMEMBER_CTRL_DEL_ITEM'));
		}

		$model = $this->getModel('predictionmember');

		if (!$model->deletePredictionResults($cid,$prediction_id))
		{
			$msg .= $d . JText::_('COM_SPORTSMANAGEMENT_ADMIN_PMEMBER_CTRL_DEL_MSG');
		}
		$msg .= $d . JText::_('COM_SPORTSMANAGEMENTADMIN_PMEMBER_CTRL_DEL_PRESULTS');

		if (!$model->deletePredictionMembers($cid))
		{
			$msg .= JText::_('COM_SPORTSMANAGEMENT_ADMIN_PMEMBER_CTRL_DEL_PMEMBERS_MSG');
		}

		$msg .= $d . JText::_('COM_SPORTSMANAGEMENT_ADMIN_PMEMBER_CTRL_DEL_PMEMBERS');

		$link = 'index.php?option=com_sportsmanagement&view=predictionmembers';
		//echo $msg;
		$this->setRedirect($link,$msg);
	}
    
  

    
    /**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'predictionmember', $prefix = 'sportsmanagementModel', $config = Array() ) 
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}