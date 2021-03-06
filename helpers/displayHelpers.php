<?php

function DeleteButton($id) {
    $opo_config = Configuration::load(__CA_APP_DIR__.'/plugins/Contribuer/conf/contribuer.conf');
    if($opo_config->get("allow_deletion", pInteger)==1) {
        return "<a href='".__CA_URL_ROOT__."/index.php/Contribuer/Do/Delete/id/".$id."'><button class='delete'>Delete</button></a>\n";
    } else {
        return "";
    }
}

function AddMediaButton($id) {
    $opo_config = Configuration::load(__CA_APP_DIR__.'/plugins/Contribuer/conf/contribuer.conf');
    if($opo_config->get("allow_media_upload", pInteger)==1) {
        return "<a href='".__CA_URL_ROOT__."/index.php/Contribuer/Do/AddMedia/id/".$id."'><button>Add media</button></a>\n";
    } else {
        return "";
    }
}

function ContribuerButtons($id = null, $user_id = null) {
    // Without any id, just exit silently
    if(!$id) return false;

    // Checking if anonymous contributions are allowed
    $opo_config = Configuration::load(__CA_APP_DIR__.'/plugins/Contribuer/conf/contribuer.conf');
    if(!$user_id && ($opo_config->get("allow_anonymous_contributions", pInteger) == 0)) return false;

    $vs_check_ownership = $opo_config->get("check_ownership", pString);
    $va_obj = new ca_objects($id);
    switch($vs_check_ownership) {
        case "creation_user":
            $va_infos = $va_obj->getCreationTimestamp();
            if($va_infos["user_id"] != $user_id) return false;
            break;
        case "last_modified_user":
            $va_infos = $va_obj->getLastChangeTimestamp();
            if($va_infos["user_id"] != $user_id) return false;
            break;
        case "0":
        default:
            break;
    }

    print "\t\t<style>
        .ContribuerButtons button {
            padding:10px;
            border-radius: 0;
            border:none;
            background-color:#eeeeee;
            margin-right:8px;
            color:#ababab;
            text-transform: uppercase;
            font-size:8px;
        }
        .ContribuerButtons button:hover {
            background-color:#f6f6f6;
        }
        button.delete {
            background-color:darkred;
            color:white;
        }
        button.delete:hover {
            background-color: red;
        }
        </style>";
    print "<span class='ContribuerButtons'>".AddMediaButton($id).DeleteButton($id)."</span>";
}