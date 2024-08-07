<?php
/* these /connect files are designed to extend data to other servers - like having your 3D Building in their 3D Community Scene */
/* permissions are required for access to some data */
/* this connect file provides thing mold information to recover a deleted item */
require_once('../core/functions/class_wtwconnect.php');
global $wtwconnect;
try {
	/* google analytics tracking (if defined in wtw_config.php) */
	$wtwconnect->trackPageView($wtwconnect->domainurl."/connect/thingmoldsrecover.php");
	
	/* get values from querystring or session */
	$zthingid = $wtwconnect->getVal('thingid','');
	$zthingind = $wtwconnect->getVal('thingind','-1');
	$zthingmoldid = $wtwconnect->getVal('thingmoldid','');
	$zconnectinggridid = $wtwconnect->getVal('connectinggridid','');
	$zconnectinggridind = $wtwconnect->getVal('connectinggridind','-1');

	/* select thing mold to recover */
	$zresults = $wtwconnect->query("
		select a1.*,
			case when a1.uploadobjectid = '' then ''
				else
					(select objectfolder 
						from ".wtw_tableprefix."uploadobjects 
						where uploadobjectid=a1.uploadobjectid limit 1)
				end as objectfolder,
			case when a1.uploadobjectid = '' then ''
				else
					(select objectfile 
						from ".wtw_tableprefix."uploadobjects 
						where uploadobjects.uploadobjectid=a1.uploadobjectid limit 1)
				end as objectfile,
			case when a1.textureid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
						(select u1.filepath 
							from ".wtw_tableprefix."uploads u2 
								left join ".wtw_tableprefix."uploads u1 
									on u2.originalid=u1.uploadid 
							where u2.uploadid=a1.textureid limit 1)
						else (select u1.filepath 
							from ".wtw_tableprefix."uploads u2 
								left join ".wtw_tableprefix."uploads u1 
									on u2.websizeid=u1.uploadid 
							where u2.uploadid=a1.textureid limit 1)
					end 
				end as texturepath,
			case when a1.texturebumpid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
						(select u1.filepath 
							from ".wtw_tableprefix."uploads u2 
								left join ".wtw_tableprefix."uploads u1 
									on u2.originalid=u1.uploadid 
							where u2.uploadid=a1.texturebumpid limit 1)
						else (select u1.filepath 
							from ".wtw_tableprefix."uploads u2 
								left join ".wtw_tableprefix."uploads u1 
									on u2.websizeid=u1.uploadid 
							where u2.uploadid=a1.texturebumpid limit 1)
					end 
				end as texturebumppath,
			case when a1.heightmapid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.originalid=u1.uploadid 
								where u2.uploadid=a1.heightmapid limit 1)
						else (select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.websizeid=u1.uploadid 
								where u2.uploadid=a1.heightmapid limit 1)
					end 
				end as heightmappath,
			case when a1.mixmapid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.originalid=u1.uploadid 
								where u2.uploadid=a1.mixmapid limit 1)
						else (select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.websizeid=u1.uploadid 
								where u2.uploadid=a1.mixmapid limit 1)
					end 
				end as mixmappath,
			case when a1.texturerid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.originalid=u1.uploadid 
								where u2.uploadid=a1.texturerid limit 1)
						else (select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.websizeid=u1.uploadid 
								where u2.uploadid=a1.texturerid limit 1)
					end 
				end as texturerpath,
			case when a1.texturegid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.originalid=u1.uploadid 
								where u2.uploadid=a1.texturegid limit 1)
						else (select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.websizeid=u1.uploadid 
								where u2.uploadid=a1.texturegid limit 1)
					end 
				end as texturegpath,
			case when a1.texturebid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.originalid=u1.uploadid 
								where u2.uploadid=a1.texturebid limit 1)
						else (select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.websizeid=u1.uploadid 
								where u2.uploadid=a1.texturebid limit 1)
					end 
				end as texturebpath,
			case when a1.texturebumprid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.originalid=u1.uploadid 
								where u2.uploadid=a1.texturebumprid limit 1)
						else (select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.websizeid=u1.uploadid 
								where u2.uploadid=a1.texturebumprid limit 1)
					end 
				end as texturebumprpath,
			case when a1.texturebumpgid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.originalid=u1.uploadid 
								where u2.uploadid=a1.texturebumpgid limit 1)
						else (select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.websizeid=u1.uploadid 
								where u2.uploadid=a1.texturebumpgid limit 1)
					end 
				end as texturebumpgpath,
			case when a1.texturebumpbid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.originalid=u1.uploadid 
								where u2.uploadid=a1.texturebumpbid limit 1)
						else (select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.websizeid=u1.uploadid 
								where u2.uploadid=a1.texturebumpbid limit 1)
					end 
				end as texturebumpbpath,
			case when a1.videoid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.videoid limit 1)
				end as video,
			case when a1.videoposterid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads where uploadid=a1.videoposterid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads where uploadid=a1.videoposterid limit 1)
					end 
				end as videoposterid,
			case when a1.videoposterid = '' then ''
				else
					case when a1.graphiclevel = '1' then 
							(select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.originalid=u1.uploadid 
								where u2.uploadid=a1.videoposterid limit 1)
						else (select u1.filepath 
								from ".wtw_tableprefix."uploads u2 
									left join ".wtw_tableprefix."uploads u1 
										on u2.websizeid=u1.uploadid 
								where u2.uploadid=a1.videoposterid limit 1)
					end 
				end as videoposter,
			case when a1.soundid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.soundid limit 1)
				end as soundpath,
			(select count(*) from ".wtw_tableprefix."thingmolds 
				where thingid='".$zthingid."' and csgmoldid=a1.thingmoldid) as csgcount
		from ".wtw_tableprefix."thingmolds a1
			left join ".wtw_tableprefix."things t1
				on a1.thingid = t1.thingid
		where a1.thingid='".$zthingid."'
		   and a1.thingmoldid='".$zthingmoldid."';");
	
	echo $wtwconnect->addConnectHeader($wtwconnect->domainname);

	$i = 0;
	$zresponse = array();
	$zmolds = array();
	/* format json return dataset */
	foreach ($zresults as $zrow) {
		$zobjectanimations = null;
		$ztempwebtext = "";
		if ($wtwconnect->hasValue($zrow["webtext"])) {
			$ztempwebtext = implode('',(array)$zrow["webtext"]);
		}
		if ($wtwconnect->hasValue($zrow["uploadobjectid"])) {
			$zobjectanimations = $wtwconnect->getobjectanimations($zrow["uploadobjectid"]);
		}
		$zcommunityinfo = array(
			'communityid'=> '',
			'communityind'=> '',
			'analyticsid'=> ''
		);
		$zbuildinginfo = array(
			'buildingid'=> '',
			'buildingind'=> '',
			'analyticsid'=> ''
		);
		$zthinginfo = array(
			'thingid'=> $zrow["thingid"],
			'thingind'=> $zthingind,
			'analyticsid'=> $zrow["analyticsid"]
		);
		$zposition = array(
			'x'=> $zrow["positionx"], 
			'y'=> $zrow["positiony"], 
			'z'=> $zrow["positionz"],
			'scroll'=>''
		);
		$zscaling = array(
			'x'=> $zrow["scalingx"], 
			'y'=> $zrow["scalingy"], 
			'z'=> $zrow["scalingz"],
			'special1'=> $zrow["special1"],
			'special2'=> $zrow["special2"]
		);
		$zrotation = array(
			'x'=> $zrow["rotationx"], 
			'y'=> $zrow["rotationy"], 
			'z'=> $zrow["rotationz"],
			'billboard'=> $zrow["billboard"]
		);
		$zcsg = array(
			'moldid'=> $zrow["csgmoldid"], 
			'moldind'=>'-1', 
			'action'=> $zrow["csgaction"], 
			'count'=> $zrow["csgcount"] 
		);
		$zobjects = array(
			'uploadobjectid'=> $zrow["uploadobjectid"], 
			'folder'=> $zrow["objectfolder"], 
			'file'=> $zrow["objectfile"],
			'objectanimations'=> $zobjectanimations,
			'light'=> '',
			'shadows'=> ''
		);
		$zgraphics = array(
			'texture'=> array(
				'id'=> $zrow["textureid"],
				'path'=> $zrow["texturepath"],
				'bumpid'=> $zrow["texturebumpid"],
				'bumppath'=> $zrow["texturebumppath"],
				'videoid'=> $zrow["videoid"],
				'video'=> $zrow["video"],
				'videoposterid'=> $zrow["videoposterid"],
				'videoposter'=> $zrow["videoposter"],
				'backupid'=> ''
			),
			'heightmap'=> array(
				'original'=> '',
				'id'=> $zrow["heightmapid"],
				'path'=> $zrow["heightmappath"],
				'minheight'=> $zrow["minheight"],
				'maxheight'=> $zrow["maxheight"],
				'mixmapid'=> $zrow["mixmapid"],
				'mixmappath'=> $zrow["mixmappath"],
				'texturerid'=> $zrow["texturerid"],
				'texturerpath'=> $zrow["texturerpath"],
				'texturegid'=> $zrow["texturegid"],
				'texturegpath'=> $zrow["texturegpath"],
				'texturebid'=> $zrow["texturebid"],
				'texturebpath'=> $zrow["texturebpath"],
				'texturebumprid'=> $zrow["texturebumprid"],
				'texturebumprpath'=> $zrow["texturebumprpath"],
				'texturebumpgid'=> $zrow["texturebumpgid"],
				'texturebumpgpath'=> $zrow["texturebumpgpath"],
				'texturebumpbid'=> $zrow["texturebumpbid"],
				'texturebumpbpath'=> $zrow["texturebumpbpath"]
			),
			'uoffset'=> $zrow["uoffset"],
			'voffset'=> $zrow["voffset"],
			'uscale'=> $zrow["uscale"],
			'vscale'=> $zrow["vscale"],
			'level'=> $zrow["graphiclevel"],
			'receiveshadows'=> $zrow["receiveshadows"],
			'waterreflection'=> $zrow["waterreflection"], 
			'webimages'=> $wtwconnect->getwebimages($zrow["thingmoldid"], "", "",-1)
		);
		$zwebtext = array(
			'webtext'=> $zrow["webtext"],
			'fullheight'=> '0',
			'scrollpos'=> '0',
			'webstyle'=> $zrow["webstyle"]
		);
		$zalttag = array(
			'name' => $zrow["alttag"]
		);
		$zpaths = array(
			'path1'=> $wtwconnect->getmoldpoints($zrow["thingmoldid"], '', '', 1, $zrow["shape"]),
			'path2'=> $wtwconnect->getmoldpoints($zrow["thingmoldid"], '', '', 2, $zrow["shape"])
		);
		$zcolor = array(
			'diffusecolor'=> $zrow["diffusecolor"],
			'emissivecolor'=> $zrow["emissivecolor"],
			'specularcolor'=> $zrow["specularcolor"],
			'ambientcolor'=> $zrow["ambientcolor"]
		);
		$zsound = array(
			'id' => $zrow["soundid"],
			'path' => $zrow["soundpath"],
			'name' => $zrow["soundname"],
			'attenuation' => $zrow["soundattenuation"],
			'loop' => $zrow["soundloop"],
			'maxdistance' => $zrow["soundmaxdistance"],
			'rollofffactor' => $zrow["soundrollofffactor"],
			'refdistance' => $zrow["soundrefdistance"],
			'coneinnerangle' => $zrow["soundconeinnerangle"],
			'coneouterangle' => $zrow["soundconeouterangle"],
			'coneoutergain' => $zrow["soundconeoutergain"],
			'sound' => ''
		);
		$zmolds[$i] = array(
			'communityinfo'=> $zcommunityinfo, 
			'buildinginfo'=> $zbuildinginfo, 
			'thinginfo'=> $zthinginfo,  
			'moldid'=> $zrow["thingmoldid"], 
			'moldind'=> '-1',
			'shape'=> $zrow["shape"], 
			'covering'=> $zrow["covering"], 
			'position'=> $zposition,
			'scaling'=> $zscaling,
			'rotation'=> $zrotation,
			'csg'=> $zcsg,
			'objects'=> $zobjects,
			'graphics'=> $zgraphics, 
			'webtext'=> $zwebtext, 
			'alttag'=> $zalttag,
			'paths'=> $zpaths,
			'color'=> $zcolor,
			'sound'=> $zsound,
			'subdivisions'=> $zrow["subdivisions"], 
			'subdivisionsshown'=>'0',
			'shown'=>'0',
			'opacity'=> $zrow["opacity"], 
			'checkcollisions'=> $zrow["checkcollisions"], 
			'ispickable'=> $zrow["ispickable"], 
			'jsfunction'=> '',
			'jsparameters'=> '',
			'actionzoneid'=> $zrow["actionzoneid"],
			'actionzone2id'=> $zrow["actionzone2id"],
			'loadactionzoneid'=> $zrow["loadactionzoneid"],
			'unloadactionzoneid'=> $zrow["unloadactionzoneid"],
			'connectinggridid'=> $zconnectinggridid,
			'connectinggridind'=> $zconnectinggridind,
			'attachmoldind'=> '-1',
			'loaded'=> '0',
			'parentname'=>'',
			'moldname'=>'');
		$i += 1;
	}
	$zresponse['molds'] = $zmolds;
	echo json_encode($zresponse);
} catch (Exception $e) {
	$wtwconnect->serror("connect-thingmoldsrecover.php=".$e->getMessage());
}
?>
