<?php
/** SportsManagement ein Programm zur Verwaltung f�r alle Sportarten
* @version         1.0.05
* @file                agegroup.php
* @author                diddipoeler, stony, svdoldie und donclumsy (diddipoeler@arcor.de)
* @copyright        Copyright: � 2013 Fussball in Europa http://fussballineuropa.de/ All rights reserved.
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
* SportsManagement ist Freie Software: Sie k�nnen es unter den Bedingungen
* der GNU General Public License, wie von der Free Software Foundation,
* Version 3 der Lizenz oder (nach Ihrer Wahl) jeder sp�teren
* ver�ffentlichten Version, weiterverbreiten und/oder modifizieren.
*
* SportsManagement wird in der Hoffnung, dass es n�tzlich sein wird, aber
* OHNE JEDE GEW�HELEISTUNG, bereitgestellt; sogar ohne die implizite
* Gew�hrleistung der MARKTF�HIGKEIT oder EIGNUNG F�R EINEN BESTIMMTEN ZWECK.
* Siehe die GNU General Public License f�r weitere Details.
*
* Sie sollten eine Kopie der GNU General Public License zusammen mit diesem
* Programm erhalten haben. Wenn nicht, siehe <http://www.gnu.org/licenses/>.
*
* Note : All ini files need to be saved as UTF-8 without BOM
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');

//jimport('joomla.application.component.model');
//require_once(JPATH_COMPONENT.DS.'models'.DS.'item.php');



/**
 * sportsmanagementModeljlextindividualsport
 * 
 * @package   
 * @author 
 * @copyright diddi
 * @version 2014
 * @access public
 */
class sportsmanagementModeljlextindividualsport extends JModelAdmin
{

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	$data	An array of input data.
	 * @param	string	$key	The name of the key for the primary key.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Check specific edit permission then general edit permission.
		return JFactory::getUser()->authorise('core.edit', 'com_sportsmanagement.message.'.((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
	}
    
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'MatchSingle', $prefix = 'sportsmanagementTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
    
    
    /**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_sportsmanagement.edit.jlextindividualsport.data', array());
		if (empty($data)) 
		{
			$data = $this->getItem();
		}
		return $data;
	}
    
    /**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		$mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        $cfg_which_media_tool = JComponentHelper::getParams($option)->get('cfg_which_media_tool',0);
        //$mainframe->enqueueMessage(JText::_('sportsmanagementModelagegroup getForm cfg_which_media_tool<br><pre>'.print_r($cfg_which_media_tool,true).'</pre>'),'Notice');
        
        // Get the form.
		$form = $this->loadForm('com_sportsmanagement.jlextindividualsport', 'jlextindividualsport', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
        

        
		return $form;
	}
    
//    function apply($data)
//    {
//        $mainframe = JFactory::getApplication();
//        $option = JRequest::getCmd('option');
//        $post = JRequest::get('post');
//        $mainframe->enqueueMessage(JText::_(get_class($this).' '.__FUNCTION__.'<br><pre>'.print_r($post,true).'</pre>'),'Notice');
//        
//    }
    
    function saveshort()
    {
        $mainframe = JFactory::getApplication();
        $option = JRequest::getCmd('option');
        // Get the input
        $pks = JRequest::getVar('cid', null, 'post', 'array');
        $post = JRequest::get('post');
        
        
//        $mainframe->enqueueMessage(get_class($this).' '.__FUNCTION__.' pks<br><pre>'.print_r($pks, true).'</pre><br>','Notice');
//        $mainframe->enqueueMessage(get_class($this).' '.__FUNCTION__.' post<br><pre>'.print_r($post, true).'</pre><br>','Notice');
        
        
        $result=true;
		for ($x=0; $x < count($pks); $x++)
		{
			// �nderungen im datum oder der uhrzeit
            $tbl = $this->getTable();;
            $tbl->load((int) $pks[$x]);
            
            list($date,$time) = explode(" ",$tbl->match_date);
            $this->_match_time_new = $post['match_time'.$pks[$x]].':00';
            $this->_match_date_new = $post['match_date'.$pks[$x]];
            $this->_match_time_old = $time;
            $this->_match_date_old = sportsmanagementHelper::convertDate($date);
            
            $post['match_date'.$pks[$x]] = sportsmanagementHelper::convertDate($post['match_date'.$pks[$x]],0);
            $post['match_date'.$pks[$x]] = $post['match_date'.$pks[$x]].' '.$post['match_time'.$pks[$x]].':00';
            
            
              
            //$mainframe->enqueueMessage($post['match_date'.$pks[$x]],'Notice');
            //$mainframe->enqueueMessage($tbl->match_date,'Notice');
            

            
            $tblMatch = & $this->getTable();
			$tblMatch->id = $pks[$x];
			$tblMatch->match_number	= $post['match_number'.$pks[$x]];
            $tblMatch->match_date = $post['match_date'.$pks[$x]];
            //$tblMatch->match_time = $post['match_time'.$pks[$x]];
            $tblMatch->crowd = $post['crowd'.$pks[$x]];
            $tblMatch->round_id	= $post['round_id'.$pks[$x]];
            $tblMatch->division_id	= $post['division_id'.$pks[$x]];
            $tblMatch->projectteam1_id = $post['projectteam1_id'.$pks[$x]];
            $tblMatch->projectteam2_id = $post['projectteam2_id'.$pks[$x]];
            
//            if ( $post['use_legs'] )
//            {
                $tblMatch->team1_result	= '';
                $tblMatch->team2_result	= '';   
                foreach ( $post['team1_result_split'.$pks[$x]] as $key => $value )
                {
                    if ( $post['team1_result_split'.$pks[$x]][$key] != '' )
                    {
                        if ( $post['team1_result_split'.$pks[$x]][$key] > $post['team2_result_split'.$pks[$x]][$key] )
                        {
                            $tblMatch->team1_result	+= 1;
                            $tblMatch->team2_result	+= 0; 
                        }
                        if ( $post['team1_result_split'.$pks[$x]][$key] < $post['team2_result_split'.$pks[$x]][$key] )
                        {
                            $tblMatch->team1_result	+= 0;
                            $tblMatch->team2_result	+= 1; 
                        }
                        if ( $post['team1_result_split'.$pks[$x]][$key] == $post['team2_result_split'.$pks[$x]][$key] )
                        {
                            $tblMatch->team1_result	+= 1;
                            $tblMatch->team2_result	+= 1; 
                        }
                    }
                }
//            }
//            else
//            {
//            
//            if ( $post['team1_result'.$pks[$x]] != '' && $post['team2_result'.$pks[$x]] != '' )    
//            {    
//            $tblMatch->team1_result	= $post['team1_result'.$pks[$x]];
//            $tblMatch->team2_result	= $post['team2_result'.$pks[$x]];
//            }
//                
//            }
            
            
            $tblMatch->team1_result_split	= implode(";",$post['team1_result_split'.$pks[$x]]);
            $tblMatch->team2_result_split	= implode(";",$post['team2_result_split'.$pks[$x]]);

			if(!$tblMatch->store()) 
            {
				//$this->setError($this->_db->getErrorMsg());
                $mainframe->enqueueMessage('sportsmanagementModelMatch saveshort<br><pre>'.print_r($this->_db->getErrorMsg(), true).'</pre><br>','Error');
				$result = false;
			}
		}
        
        // Proceed with the save
		//return parent::save($data);
        
    }

	


	



	// function save_array changed for date per match and period results
	// Gucky 2007/05/25
	function save_array($cid=null,$post=null,$zusatz=false,$project_id)
	{
		$option='com_joomleague';
		$mainframe	=& JFactory::getApplication();
		$datatable[0]='#__joomleague_match_single';
		$fields = $this->_db->getTableFields($datatable);
		
    $sporttype = $mainframe->getUserState( $option . 'sporttype' );
    $defaultvalues = array();
    $game_parts = $mainframe->getUserState( $option . 'game_parts' );
    //$game_parts = $game_parts - 1;
     
//     $mainframe->enqueueMessage(JText::_('save_array-resultsplit: '.print_r($post,true) ),'');
//     $mainframe->enqueueMessage(JText::_('save_array-resultsplit team 1: '.print_r($post['team1_result_split'.$cid],true) ),'Notice');
//     $mainframe->enqueueMessage(JText::_('save_array-resultsplit team 2: '.print_r($post['team2_result_split'.$cid],true) ),'Notice');

// in abh�ngigkeit von der sportart wird das ergebnis gespeichert    
switch(strtolower($sporttype))
{
case 'kegeln':

$xmldir = JPATH_SITE.DS.'components'.DS.'com_joomleague'.DS.'extensions'.DS.'jlextindividualsport'.DS.'admin'.DS.'assets'.DS.'extended';
$file = 'kegelnresults.xml';
$defaultconfig=array ();
$out=simplexml_load_file($xmldir.DS.$file,'SimpleXMLElement',LIBXML_NOCDATA);
$temp='';
$arr = $this->obj2Array($out);
$outName=JText::_($out->name[0]);

if (isset($arr["params"]["param"]))
					{
						foreach ($arr["params"]["param"] as $param)
						{
							//$temp .= $param["@attributes"]["name"]."=".$param["@attributes"]["default"]."\n";
							$defaultconfig[$param["@attributes"]["name"]]=$param["@attributes"]["default"];
						}
					}

					
$post['team1_result'.$cid] = 0;
$post['team2_result'.$cid] = 0;


// alles auf null setzen
$defaultconfig['JL_EXT_KEGELN_DATA_HOME_VOLLE'] = 0;
$defaultconfig['JL_EXT_KEGELN_DATA_AWAY_VOLLE'] = 0;
$defaultconfig['JL_EXT_KEGELN_DATA_HOME_ABR'] = 0;
$defaultconfig['JL_EXT_KEGELN_DATA_AWAY_ABR'] = 0;
$defaultconfig['JL_EXT_KEGELN_DATA_HOME_FW'] = 0;
$defaultconfig['JL_EXT_KEGELN_DATA_AWAY_FW'] = 0;


for ($a=0; $a < 2; $a++)
{
$post['team1_result'.$cid] = $post['team1_result'.$cid] + $post['team1_result_split'.$cid][$a];
$post['team2_result'.$cid] = $post['team2_result'.$cid] + $post['team2_result_split'.$cid][$a];
}


for ($a=0; $a < $game_parts; $a++)
{

switch ($a)
{
case 0:
$defaultconfig['JL_EXT_KEGELN_DATA_HOME_VOLLE'] = $post['team1_result_split'.$cid][$a];
$defaultconfig['JL_EXT_KEGELN_DATA_AWAY_VOLLE'] = $post['team2_result_split'.$cid][$a];
break;
case 1:
$defaultconfig['JL_EXT_KEGELN_DATA_HOME_ABR'] = $post['team1_result_split'.$cid][$a];
$defaultconfig['JL_EXT_KEGELN_DATA_AWAY_ABR'] = $post['team2_result_split'.$cid][$a];
break;
case 2:
$defaultconfig['JL_EXT_KEGELN_DATA_HOME_FW'] = $post['team1_result_split'.$cid][$a];
$defaultconfig['JL_EXT_KEGELN_DATA_AWAY_FW'] = $post['team2_result_split'.$cid][$a];
break;
}

}

foreach ( $defaultconfig as $key => $value )
{
$defaultvalues[] = $key . '=' . $value;
//$temp .= $key."=".$value."\n";
}
$temp = implode( "\n", $defaultvalues );

$query="UPDATE #__joomleague_match_single SET `extended`='".$temp."' WHERE id=".$cid;
$this->_db->setQuery($query);
if (!$this->_db->query())
		{
$mainframe->enqueueMessage(JText::_('save_array - defaultconfig: '.print_r($this->_db->getErrorMsg(),true) ),'Error');			
		}


break;

case 'tennis':
$xmldir = JPATH_SITE.DS.'components'.DS.'com_joomleague'.DS.'extensions'.DS.'jlextindividualsport'.DS.'admin'.DS.'assets'.DS.'extended';
$file = 'tennisresults.xml';
$defaultconfig=array ();
$out=simplexml_load_file($xmldir.DS.$file,'SimpleXMLElement',LIBXML_NOCDATA);
$temp='';
$arr = $this->obj2Array($out);
$outName=JText::_($out->name[0]);

if (isset($arr["params"]["param"]))
					{
						foreach ($arr["params"]["param"] as $param)
						{
							$temp .= $param["@attributes"]["name"]."=".$param["@attributes"]["default"]."\n";
							$defaultconfig[$param["@attributes"]["name"]]=$param["@attributes"]["default"];
						}
					}
					
//$mainframe->enqueueMessage(JText::_('save_array - temp: '.print_r($temp,true) ),'');					
//$mainframe->enqueueMessage(JText::_('save_array - defaultconfig: '.print_r($defaultconfig,true) ),'');

// alles auf null setzen
$defaultconfig['JL_EXT_TENNIS_DATA_HOME_MATCHES'] = 0;
$defaultconfig['JL_EXT_TENNIS_DATA_AWAY_MATCHES'] = 0;
$defaultconfig['JL_EXT_TENNIS_DATA_HOME_SETS'] = 0;
$defaultconfig['JL_EXT_TENNIS_DATA_AWAY_SETS'] = 0;
$defaultconfig['JL_EXT_TENNIS_DATA_HOME_POINTS'] = 0;
$defaultconfig['JL_EXT_TENNIS_DATA_AWAY_POINTS'] = 0;

for ($a=0; $a < $game_parts; $a++)
{
$defaultconfig['JL_EXT_TENNIS_DATA_HOME_MATCHES'] = $defaultconfig['JL_EXT_TENNIS_DATA_HOME_MATCHES'] + $post['team1_result_split'.$cid][$a];
$defaultconfig['JL_EXT_TENNIS_DATA_AWAY_MATCHES'] = $defaultconfig['JL_EXT_TENNIS_DATA_AWAY_MATCHES'] + $post['team2_result_split'.$cid][$a];

// erst die s�tze
if ( $post['team1_result_split'.$cid][$a] > $post['team2_result_split'.$cid][$a] )
{
$defaultconfig['JL_EXT_TENNIS_DATA_HOME_SETS']++;
}
elseif ( $post['team1_result_split'.$cid][$a] < $post['team2_result_split'.$cid][$a] )
{
$defaultconfig['JL_EXT_TENNIS_DATA_AWAY_SETS']++;
}

}
// zum schluss die punkte
if ( $defaultconfig['JL_EXT_TENNIS_DATA_HOME_SETS'] > $defaultconfig['JL_EXT_TENNIS_DATA_AWAY_SETS'] )
{
$defaultconfig['JL_EXT_TENNIS_DATA_HOME_POINTS']++;
$defaultconfig['JL_EXT_TENNIS_DATA_AWAY_POINTS'] = 0;
}
elseif ( $defaultconfig['JL_EXT_TENNIS_DATA_HOME_SETS'] < $defaultconfig['JL_EXT_TENNIS_DATA_AWAY_SETS'] )
{
$defaultconfig['JL_EXT_TENNIS_DATA_AWAY_POINTS']++;
$defaultconfig['JL_EXT_TENNIS_DATA_HOME_POINTS'] = 0;
}
$post['team1_result'.$cid] = $defaultconfig['JL_EXT_TENNIS_DATA_HOME_POINTS'];
$post['team2_result'.$cid] = $defaultconfig['JL_EXT_TENNIS_DATA_AWAY_POINTS'];

//$mainframe->enqueueMessage(JText::_('save_array - defaultconfig: '.print_r($defaultconfig,true) ),'Notice');

// $temp='';
// foreach ( $defaultconfig as $key => $value )
// {
// $temp .= $key."=".$value."\n";
// }

foreach ( $defaultconfig as $key => $value )
{
$defaultvalues[] = $key . '=' . $value;
//$temp .= $key."=".$value."\n";
}
$temp = implode( "\n", $defaultvalues );


$query="UPDATE #__joomleague_match_single SET `extended`='".$temp."' WHERE id=".$cid;
$this->_db->setQuery($query);
if (!$this->_db->query())
		{
$mainframe->enqueueMessage(JText::_('save_array - defaultconfig: '.print_r($this->_db->getErrorMsg(),true) ),'Error');			
		}
		
break;
}
		
		foreach($fields as $field)
		{
			$query='';
			$datafield=array_keys($field);
			if ($zusatz){$fieldzusatz=$cid;}
			foreach ($datafield as $keys)
			{
				if (isset($post[$keys.$fieldzusatz]))
				{
					$result=$post[$keys.$fieldzusatz];
					if ($keys=='match_date')
					{
						$result .= ' '.$post['match_time'.$fieldzusatz];
					}
					if ($keys=='team1_result_split' || $keys=='team2_result_split' || $keys=='homeroster' || $keys=='awayroster')
					{
						$result=trim(join(';',$result));
					}
					if ($keys=='alt_decision' && $post[$keys.$fieldzusatz]==0)
					{
						$query .= ",team1_result_decision=NULL,team2_result_decision=NULL,decision_info='',team_won=0";
					}
					if ($keys=='team1_result_decision' && strtoupper($post[$keys.$fieldzusatz])=='X' && $post['alt_decision'.$fieldzusatz]==1)
					{
						$result='';
					}
					if ($keys=='team2_result_decision' && strtoupper($post[$keys.$fieldzusatz])=='X' && $post['alt_decision'.$fieldzusatz]==1)
					{
						$result='';
					}
					if (!is_numeric($result) || ($keys == 'match_number'))
					{
						$vorzeichen="'";
					}
					else
					{
						$vorzeichen='';
					}
					if (strstr(	"crowd,formation1,formation2,homeroster,awayroster,show_report,team1_result,
								team1_bonus,team1_legs,team2_result,team2_bonus,team2_legs,
								team1_result_decision,team2_result_decision,team1_result_split,
								team2_result_split,team1_result_ot,team2_result_ot,
								team1_result_so,team2_result_so,team_won,",$keys.',') &&
					$result == '' && isset($post[$keys.$fieldzusatz]))
					{
						$result='NULL';
						$vorzeichen='';
					}
					if ($keys=='crowd' && $post['crowd'.$fieldzusatz]=='')
					{
						$result='0';
					}
					if ($result!='' || $keys=='summary' || $keys=='match_result_detail')
					{
						if ($query){$query .= ',';}
						$query .= $keys.'='.$vorzeichen.$result.$vorzeichen;
					}
					
					if ($result=='' && $keys=='time_present')
					{
						if ($query){$query .= ',';}
						$query .= $keys.'=null';
					}
					
					if ($result=='' && $keys=='match_number')
					{
						if ($query){$query .= ',';}
						$query .= $keys.'=null';
					}
				}
			}
		}
		$user =& JFactory::getUser();
		$query='UPDATE #__joomleague_match_single SET '.$query.',`modified`=NOW(),`modified_by`='.$user->id.' WHERE id='.$cid;
		$this->_db->setQuery($query);
		$this->_db->query($query);
		
	
		
		// now for ko mode
		$project=&$this->getProject();
		if ($project->project_type == 'TOURNAMENT_MODE')
		{
			return $this->save_team_to($cid,$post);
		}

		return true;
	}

	/**
	 * Method to return a playground/venue array (id,text)
		*
		* @access	public
		* @return	array
		* @since 0.1
		*/
	/*
  function getPlaygrounds()
	{
		$query='SELECT id AS value, name AS text FROM #__joomleague_playground ORDER BY text ASC ';
		$this->_db->setQuery($query);
		if (!$result=$this->_db->loadObjectList())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $result;
	}
  */
  
	

	


	
	




  
	
	function save_round_match_tennis()
	{
  $option='com_joomleague';
	$mainframe	=& JFactory::getApplication();
	$post=JRequest::get('post');
  $cid=JRequest::getVar('cid',array(),'post','array');
	JArrayHelper::toInteger($cid);
		
  $sporttype = $mainframe->getUserState( $option . 'sporttype' );
  $defaultvalues = array();
  
//   $mainframe->enqueueMessage(JText::_('save_round_match-post: '.print_r($post,true) ),'');
//   $mainframe->enqueueMessage(JText::_('save_round_match-cid: '.print_r($cid,true) ),'');
    
  $match_id = $post['match_id'];
  
  $query = ' SELECT m.team1_result, 
  m.team2_result,
  team1_result_split,
  team2_result_split,
  extended
  FROM #__joomleague_match_single AS m
	WHERE m.match_id='.(int) $match_id .' AND m.published = 1';
	$this->_db->setQuery($query);		
	$singlerows = $this->_db->loadObjectList();
    
  foreach ( $singlerows as $row )
  {
  $update['resulthome'] += $row->team1_result;
  $update['resultaway'] += $row->team2_result;
  
  $params=explode("\n",$row->extended);
  foreach($params AS $param)
	{
		list ($name,$value) = explode("=",$param);
		$configvalues[$name] += $value;
	}
    
  }
  
  //$mainframe->enqueueMessage(JText::_('save_array - configvalues: '.print_r($configvalues,true) ),'Notice');

  //$temp='';
foreach ( $configvalues as $key => $value )
{
$defaultvalues[] = $key . '=' . $value;
//$temp .= $key."=".$value."\n";
}
$temp = implode( "\n", $defaultvalues );

  $rowupdate =& JTable::getInstance('match', 'Table');
  $rowupdate->load( $match_id );
  $rowupdate->team1_result = $update['resulthome'];
  $rowupdate->team2_result = $update['resultaway'];
  $rowupdate->extended = $temp;
  if (!$rowupdate->store()) 
  {
	JError::raiseError(500, $rowupdate->getError() );
  }  
    
  }
  
  
  function save_round_match_kegeln()
	{
  $option = 'com_joomleague';
	$mainframe	=& JFactory::getApplication();
	$post = JRequest::get('post');
  $cid = JRequest::getVar('cid',array(),'post','array');
	JArrayHelper::toInteger($cid);
		
  $sporttype = $mainframe->getUserState( $option . 'sporttype' );
  $defaultvalues = array();
  
  //$mainframe->enqueueMessage(JText::_('save_round_match-post: '.print_r($post,true) ),'');
  //$mainframe->enqueueMessage(JText::_('save_round_match-cid: '.print_r($cid,true) ),'');
    
  $match_id = $post['match_id'];	

	$query = ' SELECT SUM(m.team1_result) AS resulthome, 
  SUM(m.team2_result) AS resultaway,
  team1_result_split,
  team2_result_split
  FROM #__joomleague_match_single AS m
	WHERE m.match_id='.(int) $match_id .' AND m.published = 1';
	$this->_db->setQuery($query);		
	$row = $this->_db->loadAssoc();

$row['team1_result_split'] = array();
$row['team2_result_split'] = array();

for ($x=0; $x < count($cid); $x++)
{

$tempteam1 = $post['team1_result_split'.$cid[$x]]; 
$tempteam2 = $post['team2_result_split'.$cid[$x]];

for ($a=0; $a < 3; $a++)
{
$row['team1_result_split'][$a] = $row['team1_result_split'][$a] + $tempteam1[$a];
$row['team2_result_split'][$a] = $row['team2_result_split'][$a] + $tempteam2[$a];
}

}
$row['team1_result_split'] = implode(";",$row['team1_result_split']);
$row['team2_result_split'] = implode(";",$row['team2_result_split']);


$query = ' SELECT 
  extended
  FROM #__joomleague_match_single AS m
	WHERE m.match_id='.(int) $match_id .' AND m.published = 1';
	$this->_db->setQuery($query);		
	$singlerows = $this->_db->loadObjectList();
  
  foreach ( $singlerows as $singlerow )
  {
  
  $params=explode("\n",$singlerow->extended);
  foreach($params AS $param)
	{
		list ($name,$value) = explode("=",$param);
		$configvalues[$name] += $value;
	}
    
  }

  //$mainframe->enqueueMessage(JText::_('save_round_match -configvalues: '.print_r($configvalues,true) ),'');
  

foreach ( $configvalues as $key => $value )
{
$defaultvalues[] = $key . '=' . $value;
}
$temp = implode( "\n", $defaultvalues );


  $rowupdate =& JTable::getInstance('match', 'Table');
  $rowupdate->load( $match_id );
  $rowupdate->team1_result = $row['resulthome'];
  $rowupdate->team2_result = $row['resultaway'];
  $rowupdate->team1_result_split = $row['team1_result_split'];
  $rowupdate->team2_result_split = $row['team2_result_split'];
  $rowupdate->extended = $temp;
  if (!$rowupdate->store()) 
  {
	JError::raiseError(500, $rowupdate->getError() );
  }  
		
// 	$mainframe->enqueueMessage(JText::_('save_round_match -> '.$match_id ),'Notice');
// 	$mainframe->enqueueMessage(JText::_('save_round_match -> '.$row['resulthome'] ),'Notice');
// 	$mainframe->enqueueMessage(JText::_('save_round_match -> '.$row['resultaway'] ),'Notice');

  }

  
  
  
}
?>