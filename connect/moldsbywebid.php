<?php
/* these /connect files are designed to extend data to other servers - like having your 3D Building in their 3D Community Scene */
/* permissions are required for access to some data */
/* this connect file provides molds information by 3D Community, Building, or Thing */
require_once('../core/functions/class_wtwconnect.php');
global $wtwconnect;
try {
	/* google analytics tracking (if defined in wtw_config.php) */
	$wtwconnect->trackPageView($wtwconnect->domainurl."/connect/moldsbywebid.php");
	
	/* get values from querystring or session */
	$zcommunityid = $wtwconnect->getVal('communityid','');
	$zbuildingid = $wtwconnect->getVal('buildingid','');
	$zthingid = $wtwconnect->getVal('thingid','');
	$zactionzoneid = $wtwconnect->getVal('actionzoneid','');
	$zactionzoneind = $wtwconnect->getVal('actionzoneind','-1');
	$zparentactionzoneind = $wtwconnect->getVal('parentactionzoneind','-1');
	$zparentname = $wtwconnect->getVal('parentname','');
	$zconnectinggridid = $wtwconnect->getVal('connectinggridid','');
	$zconnectinggridind = $wtwconnect->getVal('connectinggridind','-1');
	$zforcegraphiclevel = $wtwconnect->getVal('graphiclevel','-1');

	/* gets all related molds */
	$zresults = $wtwconnect->query("
		select distinct
			a1.communitymoldid,
			'' as buildingmoldid,
			'' as thingmoldid,
			a1.communitymoldid as moldid,
			a1.communityid,
			'' as buildingid,
			'' as thingid,
			'' as altconnectinggridid,
			a1.loadactionzoneid,
			a1.unloadactionzoneid,
			a1.shape,
			a1.covering,
			a1.positionx,
			a1.positiony,
			a1.positionz,
			a1.scalingx,
			a1.scalingy,
			a1.scalingz,
			a1.rotationx,
			a1.rotationy,
			a1.rotationz,
			a1.special1,
			a1.special2,
			a1.uoffset,
			a1.voffset,
			a1.uscale,
			a1.vscale,
            a1.uploadobjectid,
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
						where uploadobjectid=a1.uploadobjectid limit 1)
				end as objectfile,
            case when '".$zforcegraphiclevel."' = '1' then 1
				else
					case when '".$zforcegraphiclevel."' = '0' then 0
						else a1.graphiclevel
					end 
				end as graphiclevel,
			case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
					end 
				end as textureid,
            case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
					end 
				end as texturebumpid,
            case when a1.texturebumpid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
					end 
				end as heightmapid,
            case when a1.heightmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
					end 
				end as mixmapid,
            case when a1.mixmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
					end 
				end as texturerid,
            case when a1.texturerid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
					end 
				end as texturegid,
            case when a1.texturegid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
					end 
				end as texturebid,
            case when a1.texturebid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
					end 
				end as texturebumprid,
            case when a1.texturebumprid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
					end 
				end as texturebumpgid,
            case when a1.texturebumpgid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
					end 
				end as texturebumpbid,
            case when a1.texturebumpbid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.videoid,
            case when a1.videoid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.videoid limit 1)
				end as video,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
					end 
				end as videoposterid,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.soundid,
            case when a1.soundid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.soundid limit 1)
				end as soundpath,
            a1.soundname,
            a1.soundattenuation,
            a1.soundloop,
            a1.soundmaxdistance,
            a1.soundrollofffactor,
            a1.soundrefdistance,
            a1.soundconeinnerangle,
            a1.soundconeouterangle,
            a1.soundconeoutergain,
			a1.diffusecolor,
			a1.emissivecolor,
			a1.specularcolor,
			a1.ambientcolor,
			a1.webtext,
			a1.webstyle,
			a1.opacity,
            a1.sideorientation,
            a1.billboard,
			a1.waterreflection,
            a1.receiveshadows,
			a1.castshadows,
			a1.subdivisions,
			a1.minheight,
			a1.maxheight,
			a1.checkcollisions,
			a1.ispickable,
			a1.actionzoneid,
			a1.actionzone2id,
			a1.csgmoldid,
			a1.csgaction,
			a1.createdate,
			a1.createuserid,
			a1.updatedate,
			a1.updateuserid,
			communities.analyticsid as communityanalyticsid,
			communities.communityname,
			communities.snapshotid as communitysnapshotid,
            case when communities.snapshotid is null or communities.snapshotid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=communities.snapshotid limit 1)
				end as communitysnapshoturl,
			'' as buildinganalyticsid,
			'' as buildingname,
			'' as buildingsnapshotid,
			'' as buildingsnapshoturl,
			'' as thinganalyticsid,
			'' as thingname,
			'' as thingsnapshotid,
			'' as thingsnapshoturl,
			a1.alttag as communityalttag,
			'' as buildingalttag,
			'' as thingalttag,
            a1.jsfunction,
            a1.jsparameters,
            (select count(*) from ".wtw_tableprefix."communitymolds 
				where communityid='".$zcommunityid."' 
					and csgmoldid=a1.communitymoldid) as csgcount,
            case when a1.shape = 'terrain' then 10
				when a1.shape = 'floor' then 9
                else
					0
				end as sortorder
		from ".wtw_tableprefix."communitymolds a1 
			inner join (select * from ".wtw_tableprefix."actionzones 
					where communityid='".$zcommunityid."' 
						and (not communityid='') and deleted=0) a2
				on a1.loadactionzoneid = a2.actionzoneid
				or a1.unloadactionzoneid = a2.actionzoneid
				or a1.actionzoneid = a2.actionzoneid
			left join (select * 
					from ".wtw_tableprefix."communities 
					where communityid='".$zcommunityid."' and deleted=0) communities
				on a1.communityid =  communities.communityid
		where a1.deleted=0
		
		union all
		
		select distinct 
			'' as communitymoldid,
			a1.buildingmoldid,
			'' as thingmoldid,
			a1.buildingmoldid as moldid,
			'' as communityid,
			a1.buildingid,
			'' as thingid,
			'' as altconnectinggridid,
			a1.loadactionzoneid,
			a1.unloadactionzoneid,
			a1.shape,
			a1.covering,
			a1.positionx,
			a1.positiony,
			a1.positionz,
			a1.scalingx,
			a1.scalingy,
			a1.scalingz,
			a1.rotationx,
			a1.rotationy,
			a1.rotationz,
			a1.special1,
			a1.special2,
			a1.uoffset,
			a1.voffset,
			a1.uscale,
			a1.vscale,
            a1.uploadobjectid,
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
						where uploadobjectid=a1.uploadobjectid limit 1)
				end as objectfile,
            case when '".$zforcegraphiclevel."' = '1' then 1
				else
					case when '".$zforcegraphiclevel."' = '0' then 0
						else a1.graphiclevel
					end 
				end as graphiclevel,
			case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
					end 
				end as textureid,
            case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads
								where uploadid=a1.texturebumpid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
					end 
				end as texturebumpid,
            case when a1.texturebumpid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
					end 
				end as heightmapid,
            case when a1.heightmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
					end 
				end as mixmapid,
            case when a1.mixmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
					end 
				end as texturerid,
            case when a1.texturerid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
					end 
				end as texturegid,
            case when a1.texturegid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
									where uploadid=a1.texturebid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
									where uploadid=a1.texturebid limit 1)
					end 
				end as texturebid,
            case when a1.texturebid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
									where uploadid=a1.texturebumprid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
					end 
				end as texturebumprid,
            case when a1.texturebumprid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
					end 
				end as texturebumpgid,
            case when a1.texturebumpgid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
					end 
				end as texturebumpbid,
            case when a1.texturebumpbid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.videoid,
            case when a1.videoid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.videoid limit 1)
				end as video,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
					end 
				end as videoposterid,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.soundid,
            case when a1.soundid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.soundid limit 1)
				end as soundpath,
            a1.soundname,
            a1.soundattenuation,
            a1.soundloop,
            a1.soundmaxdistance,
            a1.soundrollofffactor,
            a1.soundrefdistance,
            a1.soundconeinnerangle,
            a1.soundconeouterangle,
            a1.soundconeoutergain,
			a1.diffusecolor,
			a1.emissivecolor,
			a1.specularcolor,
			a1.ambientcolor,
			a1.webtext,
			a1.webstyle,
			a1.opacity,
            a1.sideorientation,
            a1.billboard,
			a1.waterreflection,
            a1.receiveshadows,
			a1.castshadows,
			a1.subdivisions,
			a1.minheight,
			a1.maxheight,
			a1.checkcollisions,
			a1.ispickable,
			a1.actionzoneid,
			a1.actionzone2id,
			a1.csgmoldid,
			a1.csgaction,
			a1.createdate,
			a1.createuserid,
			a1.updatedate,
			a1.updateuserid,
			'' as communityanalyticsid,
			'' as communityname,
			'' as communitysnapshotid,
			'' as communitysnapshoturl,
			buildings.analyticsid as buildinganalyticsid,
			buildings.buildingname,
			buildings.snapshotid as buildingsnapshotid,
            case when buildings.snapshotid is null or buildings.snapshotid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=buildings.snapshotid limit 1)
				end as buildingsnapshoturl,
			'' as thinganalyticsid,
			'' as thingname,
			'' as thingsnapshotid,
			'' as thingsnapshoturl,
			'' as communityalttag,
			a1.alttag as buildingalttag,
			'' as thingalttag,
            a1.jsfunction,
            a1.jsparameters,
            (select count(*) from ".wtw_tableprefix."buildingmolds 
				where buildingid='".$zbuildingid."' and csgmoldid=a1.buildingmoldid) as csgcount,
            case when a1.shape = 'terrain' then 10
				when a1.shape = 'floor' then 9
                else
					0
				end as sortorder
		from ".wtw_tableprefix."buildingmolds a1 
			inner join (select * from ".wtw_tableprefix."actionzones 
					where buildingid='".$zbuildingid."' and (not buildingid='') and deleted=0) a2
				on a1.loadactionzoneid = a2.actionzoneid
				or a1.unloadactionzoneid = a2.actionzoneid
				or a1.actionzoneid = a2.actionzoneid
			left join (select * 
					from ".wtw_tableprefix."buildings 
					where buildingid='".$zbuildingid."' and deleted=0) buildings
				on a1.buildingid =  buildings.buildingid
		where a1.deleted=0
			
		union all

		select distinct 
			'' as communitymoldid,
			'' as buildingmoldid,
			a1.thingmoldid,
			a1.thingmoldid as moldid,
			'' as communityid,
			'' as buildingid,
			a1.thingid,
			'' as altconnectinggridid,
			a1.loadactionzoneid,
			a1.unloadactionzoneid,
			a1.shape,
			a1.covering,
			a1.positionx,
			a1.positiony,
			a1.positionz,
			a1.scalingx,
			a1.scalingy,
			a1.scalingz,
			a1.rotationx,
			a1.rotationy,
			a1.rotationz,
			a1.special1,
			a1.special2,
			a1.uoffset,
			a1.voffset,
			a1.uscale,
			a1.vscale,
            a1.uploadobjectid,
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
						where uploadobjectid=a1.uploadobjectid limit 1)
				end as objectfile,
            case when '".$zforcegraphiclevel."' = '1' then 1
				else
					case when '".$zforcegraphiclevel."' = '0' then 0
						else a1.graphiclevel
					end 
				end as graphiclevel,
			case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
					end 
				end as textureid,
            case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
					end 
				end as texturebumpid,
            case when a1.texturebumpid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
					end 
				end as heightmapid,
            case when a1.heightmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
					end 
				end as mixmapid,
            case when a1.mixmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
					end 
				end as texturerid,
            case when a1.texturerid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
					end 
				end as texturegid,
            case when a1.texturegid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
					end 
				end as texturebid,
            case when a1.texturebid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
					end 
				end as texturebumprid,
            case when a1.texturebumprid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
					end 
				end as texturebumpgid,
            case when a1.texturebumpgid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
					end 
				end as texturebumpbid,
            case when a1.texturebumpbid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.videoid,
            case when a1.videoid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.videoid limit 1)
				end as video,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
					end 
				end as videoposterid,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.soundid,
            case when a1.soundid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.soundid limit 1)
				end as soundpath,
            a1.soundname,
            a1.soundattenuation,
            a1.soundloop,
            a1.soundmaxdistance,
            a1.soundrollofffactor,
            a1.soundrefdistance,
            a1.soundconeinnerangle,
            a1.soundconeouterangle,
            a1.soundconeoutergain,
			a1.diffusecolor,
			a1.emissivecolor,
			a1.specularcolor,
			a1.ambientcolor,
			a1.webtext,
			a1.webstyle,
			a1.opacity,
            a1.sideorientation,
            a1.billboard,
			a1.waterreflection,
            a1.receiveshadows,
			a1.castshadows,
			a1.subdivisions,
			a1.minheight,
			a1.maxheight,
			a1.checkcollisions,
			a1.ispickable,
			a1.actionzoneid,
			a1.actionzone2id,
			a1.csgmoldid,
			a1.csgaction,
			a1.createdate,
			a1.createuserid,
			a1.updatedate,
			a1.updateuserid,
			'' as communityanalyticsid,
			'' as communityname,
			'' as communitysnapshotid,
			'' as communitysnapshoturl,
			'' as buildinganalyticsid,
			'' as buildingname,
			'' as buildingsnapshotid,
			'' as buildingsnapshoturl,
			things.analyticsid as thinganalyticsid,
			things.thingname,
			things.snapshotid as thingsnapshotid,
            case when things.snapshotid is null or things.snapshotid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=things.snapshotid limit 1)
				end as thingsnapshoturl,
			'' as communityalttag,
			'' as buildingalttag,
			a1.alttag as thingalttag,
            a1.jsfunction,
            a1.jsparameters,
            (select count(*) from ".wtw_tableprefix."thingmolds 
				where thingid='".$zthingid."' and csgmoldid=a1.thingmoldid) as csgcount,
            case when a1.shape = 'terrain' then 10
				when a1.shape = 'floor' then 9
                else
					0
				end as sortorder
		from ".wtw_tableprefix."thingmolds a1 
			inner join (select * 
					from ".wtw_tableprefix."actionzones 
					where thingid='".$zthingid."' 
						and (not thingid='') and deleted=0) a2
				on a1.loadactionzoneid = a2.actionzoneid
				or a1.unloadactionzoneid = a2.actionzoneid
				or a1.actionzoneid = a2.actionzoneid
			left join (select * 
					from ".wtw_tableprefix."things 
					where thingid='".$zthingid."' and deleted=0) things
				on a1.thingid =  things.thingid
		where a1.deleted=0
	 
		union all
		
		select distinct 
			'' as communitymoldid,
			'' as buildingmoldid,
			a1.thingmoldid,
			a1.thingmoldid as moldid,
			'' as communityid,
			'' as buildingid,
			a1.thingid,
			connectinggrids.connectinggridid as altconnectinggridid,
			connectinggrids.altloadactionzoneid as loadactionzoneid,
			a1.unloadactionzoneid,
			a1.shape,
			a1.covering,
			a1.positionx,
			a1.positiony,
			a1.positionz,
			a1.scalingx,
			a1.scalingy,
			a1.scalingz,
			a1.rotationx,
			a1.rotationy,
			a1.rotationz,
			a1.special1,
			a1.special2,
			a1.uoffset,
			a1.voffset,
			a1.uscale,
			a1.vscale,
            a1.uploadobjectid,
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
						where uploadobjectid=a1.uploadobjectid limit 1)
				end as objectfile,
            case when '".$zforcegraphiclevel."' = '1' then 1
				else
					case when '".$zforcegraphiclevel."' = '0' then 0
						else a1.graphiclevel
					end 
				end as graphiclevel,
			case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
					end 
				end as textureid,
            case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
					end 
				end as texturebumpid,
            case when a1.texturebumpid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 	
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
					end 
				end as heightmapid,
            case when a1.heightmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
					end 
				end as mixmapid,
            case when a1.mixmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 	
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
					end 
				end as texturerid,
            case when a1.texturerid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
					end 
				end as texturegid,
            case when a1.texturegid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
					end 
				end as texturebid,
            case when a1.texturebid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
					end 
				end as texturebumprid,
            case when a1.texturebumprid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
					end 
				end as texturebumpgid,
            case when a1.texturebumpgid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
					end 
				end as texturebumpbid,
            case when a1.texturebumpbid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.videoid,
            case when a1.videoid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.videoid limit 1)
				end as video,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
					end 
				end as videoposterid,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.soundid,
            case when a1.soundid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.soundid limit 1)
				end as soundpath,
            a1.soundname,
            a1.soundattenuation,
            a1.soundloop,
            a1.soundmaxdistance,
            a1.soundrollofffactor,
            a1.soundrefdistance,
            a1.soundconeinnerangle,
            a1.soundconeouterangle,
            a1.soundconeoutergain,
			a1.diffusecolor,
			a1.emissivecolor,
			a1.specularcolor,
			a1.ambientcolor,
			a1.webtext,
			a1.webstyle,
			a1.opacity,
            a1.sideorientation,
            a1.billboard,
			a1.waterreflection,
            a1.receiveshadows,
			a1.castshadows,
			a1.subdivisions,
			a1.minheight,
			a1.maxheight,
			a1.checkcollisions,
			a1.ispickable,
			a1.actionzoneid,
			a1.actionzone2id,
			a1.csgmoldid,
			a1.csgaction,
			a1.createdate,
			a1.createuserid,
			a1.updatedate,
			a1.updateuserid,
			'' as communityanalyticsid,
			'' as communityname,
			'' as communitysnapshotid,
			'' as communitysnapshoturl,
			'' as buildinganalyticsid,
			'' as buildingname,
			'' as buildingsnapshotid,
			'' as buildingsnapshoturl,
			things.analyticsid as thinganalyticsid,
			things.thingname,
			things.snapshotid as thingsnapshotid,
            case when things.snapshotid is null or things.snapshotid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=things.snapshotid limit 1)
				end as thingsnapshoturl,
			'' as communityalttag,
			'' as buildingalttag,
			a1.alttag as thingalttag,
            a1.jsfunction,
            a1.jsparameters,
            (select count(*) from ".wtw_tableprefix."thingmolds 
				where thingid='".$zthingid."' 
					and csgmoldid=a1.thingmoldid) as csgcount,
            case when a1.shape = 'terrain' then 10
				when a1.shape = 'floor' then 9
                else
					0
				end as sortorder
		from (select * from ".wtw_tableprefix."connectinggrids 
					where parentwebid='".$zbuildingid."' 
						and (not parentwebid='') 
						and parentwebtype='building' 
						and childwebtype='thing' 
						and (not altloadactionzoneid='') 
						and deleted=0) connectinggrids
			inner join ".wtw_tableprefix."thingmolds a1
				on connectinggrids.childwebid = a1.thingid
			left join (select * 
					from ".wtw_tableprefix."things where deleted=0) things
				on connectinggrids.childwebid =  things.thingid
		where a1.deleted=0

		union all
		
		select distinct 
			'' as communitymoldid,
			'' as buildingmoldid,
			a1.thingmoldid,
			a1.thingmoldid as moldid,
			'' as communityid,
			'' as buildingid,
			a1.thingid,
			connectinggrids.connectinggridid as altconnectinggridid,
			connectinggrids.altloadactionzoneid as loadactionzoneid,
			a1.unloadactionzoneid,
			a1.shape,
			a1.covering,
			a1.positionx,
			a1.positiony,
			a1.positionz,
			a1.scalingx,
			a1.scalingy,
			a1.scalingz,
			a1.rotationx,
			a1.rotationy,
			a1.rotationz,
			a1.special1,
			a1.special2,
			a1.uoffset,
			a1.voffset,
			a1.uscale,
			a1.vscale,
            a1.uploadobjectid,
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
						where uploadobjectid=a1.uploadobjectid limit 1)
				end as objectfile,
            case when '".$zforcegraphiclevel."' = '1' then 1
				else
					case when '".$zforcegraphiclevel."' = '0' then 0
						else a1.graphiclevel
					end 
				end as graphiclevel,
			case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
					end 
				end as textureid,
            case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
					end 
				end as texturebumpid,
            case when a1.texturebumpid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
					end 
				end as heightmapid,
            case when a1.heightmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
					end 
				end as mixmapid,
            case when a1.mixmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
					end 
				end as texturerid,
            case when a1.texturerid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
					end 
				end as texturegid,
            case when a1.texturegid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
					end 
				end as texturebid,
            case when a1.texturebid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
					end 
				end as texturebumprid,
            case when a1.texturebumprid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
					end 
				end as texturebumpgid,
            case when a1.texturebumpgid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
					end 
				end as texturebumpbid,
            case when a1.texturebumpbid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.videoid,
            case when a1.videoid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.videoid limit 1)
				end as video,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
					end 
				end as videoposterid,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.soundid,
            case when a1.soundid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.soundid limit 1)
				end as soundpath,
            a1.soundname,
            a1.soundattenuation,
            a1.soundloop,
            a1.soundmaxdistance,
            a1.soundrollofffactor,
            a1.soundrefdistance,
            a1.soundconeinnerangle,
            a1.soundconeouterangle,
            a1.soundconeoutergain,
			a1.diffusecolor,
			a1.emissivecolor,
			a1.specularcolor,
			a1.ambientcolor,
			a1.webtext,
			a1.webstyle,
			a1.opacity,
            a1.sideorientation,
            a1.billboard,
			a1.waterreflection,
            a1.receiveshadows,
			a1.castshadows,
			a1.subdivisions,
			a1.minheight,
			a1.maxheight,
			a1.checkcollisions,
			a1.ispickable,
			a1.actionzoneid,
			a1.actionzone2id,
			a1.csgmoldid,
			a1.csgaction,
			a1.createdate,
			a1.createuserid,
			a1.updatedate,
			a1.updateuserid,
			'' as communityanalyticsid,
			'' as communityname,
			'' as communitysnapshotid,
			'' as communitysnapshoturl,
			'' as buildinganalyticsid,
			'' as buildingname,
			'' as buildingsnapshotid,
			'' as buildingsnapshoturl,
			things.analyticsid as thinganalyticsid,
			things.thingname,
			things.snapshotid as thingsnapshotid,
            case when things.snapshotid is null or things.snapshotid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=things.snapshotid limit 1)
				end as thingsnapshoturl,
			'' as communityalttag,
			'' as buildingalttag,
			a1.alttag as thingalttag,
            a1.jsfunction,
            a1.jsparameters,
            (select count(*) from ".wtw_tableprefix."thingmolds 
					where thingid='".$zthingid."' 
						and csgmoldid=a1.thingmoldid) as csgcount,
            case when a1.shape = 'terrain' then 10
				when a1.shape = 'floor' then 9
                else
					0
				end as sortorder
		FROM (select * from ".wtw_tableprefix."connectinggrids 
					where parentwebid='".$zcommunityid."' 
						and (not parentwebid='') 
						and parentwebtype='community' 
						and childwebtype='thing' 
						and (not altloadactionzoneid='') 
						and deleted=0) connectinggrids
			inner join ".wtw_tableprefix."thingmolds a1
				on connectinggrids.childwebid = a1.thingid
			left join (select * 
					from ".wtw_tableprefix."things where deleted=0) things
				on connectinggrids.childwebid =  things.thingid
		where a1.deleted=0
		
		union all
		
		select distinct 
			'' as communitymoldid,
			'' as buildingmoldid,
			a1.thingmoldid,
			a1.thingmoldid as moldid,
			'' as communityid,
			'' as buildingid,
			a1.thingid,
			connectinggrids.connectinggridid as altconnectinggridid,
			connectinggrids.altloadactionzoneid as loadactionzoneid,
			a1.unloadactionzoneid,
			a1.shape,
			a1.covering,
			a1.positionx,
			a1.positiony,
			a1.positionz,
			a1.scalingx,
			a1.scalingy,
			a1.scalingz,
			a1.rotationx,
			a1.rotationy,
			a1.rotationz,
			a1.special1,
			a1.special2,
			a1.uoffset,
			a1.voffset,
			a1.uscale,
			a1.vscale,
            a1.uploadobjectid,
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
						where uploadobjectid=a1.uploadobjectid limit 1)
				end as objectfile,
            case when '".$zforcegraphiclevel."' = '1' then 1
				else
					case when '".$zforcegraphiclevel."' = '0' then 0
						else a1.graphiclevel
					end 
				end as graphiclevel,
			case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.textureid limit 1)
					end 
				end as textureid,
            case when a1.textureid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpid limit 1)
					end 
				end as texturebumpid,
            case when a1.texturebumpid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.heightmapid limit 1)
					end 
				end as heightmapid,
            case when a1.heightmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.mixmapid limit 1)
					end 
				end as mixmapid,
            case when a1.mixmapid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturerid limit 1)
					end 
				end as texturerid,
            case when a1.texturerid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturegid limit 1)
					end 
				end as texturegid,
            case when a1.texturegid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebid limit 1)
					end 
				end as texturebid,
            case when a1.texturebid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumprid limit 1)
					end 
				end as texturebumprid,
            case when a1.texturebumprid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpgid limit 1)
					end 
				end as texturebumpgid,
            case when a1.texturebumpgid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.texturebumpbid limit 1)
					end 
				end as texturebumpbid,
            case when a1.texturebumpbid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.videoid,
            case when a1.videoid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.videoid limit 1)
				end as video,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
							(select originalid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
						else (select websizeid 
								from ".wtw_tableprefix."uploads 
								where uploadid=a1.videoposterid limit 1)
					end 
				end as videoposterid,
            case when a1.videoposterid = '' then ''
				else
					case when (a1.graphiclevel = '1' and not '".$zforcegraphiclevel."' = '0') or '".$zforcegraphiclevel."' = '1' then 
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
            a1.soundid,
            case when a1.soundid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=a1.soundid limit 1)
				end as soundpath,
            a1.soundname,
            a1.soundattenuation,
            a1.soundloop,
            a1.soundmaxdistance,
            a1.soundrollofffactor,
            a1.soundrefdistance,
            a1.soundconeinnerangle,
            a1.soundconeouterangle,
            a1.soundconeoutergain,
			a1.diffusecolor,
			a1.emissivecolor,
			a1.specularcolor,
			a1.ambientcolor,
			a1.webtext,
			a1.webstyle,
			a1.opacity,
            a1.sideorientation,
            a1.billboard,
			a1.waterreflection,
            a1.receiveshadows,
            a1.castshadows,
			a1.subdivisions,
			a1.minheight,
			a1.maxheight,
			a1.checkcollisions,
			a1.ispickable,
			a1.actionzoneid,
			a1.actionzone2id,
			a1.csgmoldid,
			a1.csgaction,
			a1.createdate,
			a1.createuserid,
			a1.updatedate,
			a1.updateuserid,
			'' as communityanalyticsid,
			'' as communityname,
			'' as communitysnapshotid,
			'' as communitysnapshoturl,
			'' as buildinganalyticsid,
			'' as buildingname,
			'' as buildingsnapshotid,
			'' as buildingsnapshoturl,
			things.analyticsid as thinganalyticsid,
			things.thingname,
			things.snapshotid as thingsnapshotid,
            case when things.snapshotid is null or things.snapshotid = '' then ''
				else
					(select filepath 
						from ".wtw_tableprefix."uploads 
						where uploadid=things.snapshotid limit 1)
				end as thingsnapshoturl,
			'' as communityalttag,
			'' as buildingalttag,
			a1.alttag as thingalttag,
            a1.jsfunction,
            a1.jsparameters,
            (select count(*) from ".wtw_tableprefix."thingmolds 
					where thingid='".$zthingid."' 
						and csgmoldid=a1.thingmoldid) as csgcount,
            case when a1.shape = 'terrain' then 10
				when a1.shape = 'floor' then 9
                else
					0
				end as sortorder
		from (select * from ".wtw_tableprefix."connectinggrids 
					where parentwebid='".$zcommunityid."' 
						and (not parentwebid='') 
						and parentwebtype='community' 
						and childwebtype='building' 
						and (not altloadactionzoneid='') 
						and deleted=0) connectinggrids
			inner join ".wtw_tableprefix."thingmolds a1
				on connectinggrids.childwebid = a1.thingid
			left join (select * 
					from ".wtw_tableprefix."things 
					where deleted=0) things
				on connectinggrids.childwebid =  things.thingid
		where a1.deleted=0

		order by 
			 sortorder desc, csgmoldid desc, moldid;");
	
	echo $wtwconnect->addConnectHeader($wtwconnect->domainname);

	$i = 0;
	$zresponse = array();
	$zmolds = array();
	/* format json return dataset */
	foreach ($zresults as $zrow) {
		$zobjectanimations = null;
		$ztempwebtext = '';
		$zinloadactionzone = '0';
		if ($zactionzoneid == $zrow["loadactionzoneid"] && $zactionzoneid != "") {
			$zinloadactionzone = '1';
		}
		if ($wtwconnect->hasValue($zrow["webtext"])) {
			$ztempwebtext = implode('',(array)$zrow["webtext"]);
		}
		if ($wtwconnect->hasValue($zrow["uploadobjectid"])) {
			$zobjectanimations = $wtwconnect->getobjectanimations($zrow["uploadobjectid"]);
		}
		$zcommunityinfo = array(
			'communityid'=> $zrow["communityid"],
			'communityind'=> '',
			'communityname'=> $wtwconnect->escapeHTML($zrow["communityname"]),
			'snapshotid' => $zrow["communitysnapshotid"],
			'snapshoturl' => $zrow["communitysnapshoturl"],
			'analyticsid'=> $zrow["communityanalyticsid"]
		);
		$zbuildinginfo = array(
			'buildingid'=> $zrow["buildingid"],
			'buildingind'=> '',
			'buildingname'=> $wtwconnect->escapeHTML($zrow["buildingname"]),
			'snapshotid' => $zrow["buildingsnapshotid"],
			'snapshoturl' => $zrow["buildingsnapshoturl"],
			'analyticsid'=> $zrow["buildinganalyticsid"]
		);
		$zthinginfo = array(
			'thingid'=> $zrow["thingid"],
			'thingind'=> '',
			'thingname'=> $wtwconnect->escapeHTML($zrow["thingname"]),
			'snapshotid' => $zrow["thingsnapshotid"],
			'snapshoturl' => $zrow["thingsnapshoturl"],
			'analyticsid'=> $zrow["thinganalyticsid"]
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
				'backupid'=> '',
				'loaded'=> '0'
			),
			'heightmap'=> array(
				'original'=> $zrow["heightmappath"],
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
			'castshadows'=> $zrow["castshadows"],
			'waterreflection'=> $zrow["waterreflection"], 
			'webimages'=> $wtwconnect->getwebimages($zrow["thingmoldid"], $zrow["buildingmoldid"], $zrow["communitymoldid"], $zrow["graphiclevel"])
		);
		$zwebtext = array(
			'webtext'=> $zrow["webtext"],
			'fullheight'=> '0',
			'scrollpos'=> '0',
			'webstyle'=> $zrow["webstyle"]
		);
		$zalttag = array(
			'name'=> ''
		);
		$zpaths = array(
			'path1'=> $wtwconnect->getmoldpoints($zrow["thingmoldid"], $zrow["buildingmoldid"], $zrow["communitymoldid"], 1, $zrow["shape"]),
			'path2'=> $wtwconnect->getmoldpoints($zrow["thingmoldid"], $zrow["buildingmoldid"], $zrow["communitymoldid"], 2, $zrow["shape"])
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
		if ($wtwconnect->hasValue($zrow['communitymoldid'])) {
			$zalttag = array(
				'name'=> $zrow['communityalttag']
			);
		}
		if ($wtwconnect->hasValue($zrow['buildingmoldid'])) {
			$zalttag = array(
				'name'=> $zrow['buildingalttag']
			);
		}
		if ($wtwconnect->hasValue($zrow['thingmoldid'])) {
			$zalttag = array(
				'name'=> $zrow['thingalttag']
			);
		}
		$zmolds[$i] = array(
			'communityinfo'=> $zcommunityinfo, 
			'buildinginfo'=> $zbuildinginfo, 
			'thinginfo'=> $zthinginfo,
			'serverfranchiseid' => '',
			'moldid'=> $zrow["moldid"], 
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
			'jsfunction'=> $zrow["jsfunction"],
			'jsparameters'=> $zrow["jsparameters"],
			'actionzoneid'=> $zrow["actionzoneid"],
			'actionzoneind'=> $zactionzoneind,
			'actionzone2id'=> $zrow["actionzone2id"],
			'actionzone2ind'=> '-1',
			'parentactionzoneind'=> $zparentactionzoneind,
			'loadactionzoneid'=> $zrow["loadactionzoneid"],
			'loadactionzoneind'=> '-1',
			'unloadactionzoneid'=> $zrow["unloadactionzoneid"],
			'unloadactionzoneind'=> '-1',
			'inloadactionzone'=> $zinloadactionzone,
			'altconnectinggridid'=> $zrow["altconnectinggridid"],
			'altconnectinggridind'=> '-1',
			'connectinggridid'=> $zconnectinggridid,
			'connectinggridind'=> $zconnectinggridind,
			'attachmoldind'=> '-1',
			'loaded'=> '0',
			'parentname'=> $zparentname,
			'moldname'=> '');
		$i += 1;
	}
	$zresponse['molds'] = $zmolds;
	echo json_encode($zresponse);
} catch (Exception $e) {
	$wtwconnect->serror("connect-moldsbywebid.php=".$e->getMessage());
}
?>
