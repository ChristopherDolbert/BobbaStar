<?php
/*===================================================+
|| # HoloCMS - Website and Content Management System
|+===================================================+
|| # Copyright &copy; 2008 Meth0d. All rights reserved.
|| # http://www.meth0d.org
|+===================================================+
|| # HoloCMS is provided "as is" and comes without
|| # warrenty of any kind. HoloCMS is free software!
|+===================================================*/

include('../config.php');

if(getContent('forum-enabled') !== "1"){ header("Location: index.php"); exit; }
$sql = $bdd->prepare("SELECT * FROM groups_details WHERE id=:id LIMIT 1");
$sql->bindValue(':id', $_POST['groupId'], PDO::PARAM_INT);
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);


if($row['topics'] == 0) {
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="group-postlist-list" id="group-postlist-list">
<tr>
    <td class="post-header-link" valign="top" style="width: 148px;"></td>
    <td class="post-header-name" valign="top"></td>
    <td align="right">
</tr>
<tr>
	<td colspan="3" class="post-list-row-container"><div id="new-topic-preview"></div></td>
</tr>

<tr class="new-topic-entry-label" id="new-topic-entry-label">
	<td class="new-topic-entry-label">Topic:</td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
	    <div class="post-list-content-element"><input type="text" size="50" id="new-topic-name"/></div>
	    </td>
	    </tr>
	    </table>
    </td>
</tr>
<tr class="topic-name-error">
    <td></td>
    <td colspan="2">
        <div id="topic-name-error"></div>
    </td>
</tr>

<tr id="new-post-entry-message" style="display:none;">
	<td class="new-post-entry-label"><div class="new-post-entry-label" id="new-post-entry-label">Message:</div></td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
		<input type="hidden" id="edit-type"/>
		<input type="hidden" id="post-id"/>
        <a href="#" class="preview-post-link" id="topic-form-preview">Pr&eacute;voir &raquo;</a>
        <input type="hidden" id="spam-message" value="Spam detected!"/>
		<textarea id="post-message" class="new-post-entry-message" rows="5" name="message" ></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("post-message");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
        var colors = { "red" : ["#d80000", "Rouge"],
            "orange" : ["#fe6301", "Orange"],
            "yellow" : ["#ffce00", "Jaune"],
            "green" : ["#6cc800", "Vert"],
            "cyan" : ["#00c6c4", "Ciel"],
            "blue" : ["#0070d7", "Bleu"],
            "gray" : ["#828282", "Gris"],
            "black" : ["#000000", "Noir"]
        };
        bbcodeToolbar.addColorSelect("Couleurs", colors, false);
    </script>
	    <br /><br/>
        <a class="new-button red-button cancel-icon" href="forum.php"><b><span></span>Quitter</b><i></i></a>
        <a id="topic-form-save" class="new-button green-button save-icon" href="#"><b><span></span>Sauvegarder</b><i></i></a>
        </td>
        </tr>
        </table>
	</td>
</tr>

</table>
<div id="new-post-preview" style="display:none;">
</div>
<?php }elseif($row['topics'] == 1) {
		$stmt = $bdd->prepare('SELECT * FROM groups_memberships WHERE userid = :userid AND groupid = :groupid LIMIT 1');
        $stmt->execute(['userid' => $user['id'], 'groupid' => $_POST['groupId']]);
        $check = $stmt->fetch();
        
        // Vérifier s'il y a des résultats
        if($check->rowCount() > 0) {  ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="group-postlist-list" id="group-postlist-list">
<tr>
    <td class="post-header-link" valign="top" style="width: 148px;"></td>
    <td class="post-header-name" valign="top"></td>
    <td align="right">
</tr>
<tr>
	<td colspan="3" class="post-list-row-container"><div id="new-topic-preview"></div></td>
</tr>

<tr class="new-topic-entry-label" id="new-topic-entry-label">
	<td class="new-topic-entry-label">Topic:</td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
	    <div class="post-list-content-element"><input type="text" size="50" id="new-topic-name"/></div>
	    </td>
	    </tr>
	    </table>
    </td>
</tr>
<tr class="topic-name-error">
    <td></td>
    <td colspan="2">
        <div id="topic-name-error"></div>
    </td>
</tr>

<tr id="new-post-entry-message" style="display:none;">
	<td class="new-post-entry-label"><div class="new-post-entry-label" id="new-post-entry-label">Message:</div></td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
		<input type="hidden" id="edit-type"/>
		<input type="hidden" id="post-id"/>
        <a href="#" class="preview-post-link" id="topic-form-preview">Pr&eacute;voir &raquo;</a>
        <input type="hidden" id="spam-message" value="Spam detected!"/>
		<textarea id="post-message" class="new-post-entry-message" rows="5" name="message" ></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("post-message");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
        var colors = { "red" : ["#d80000", "Red"],
            "orange" : ["#fe6301", "Orange"],
            "yellow" : ["#ffce00", "Yellow"],
            "green" : ["#6cc800", "Green"],
            "cyan" : ["#00c6c4", "Cyan"],
            "blue" : ["#0070d7", "Blue"],
            "gray" : ["#828282", "Grey"],
            "black" : ["#000000", "Black"]
        };
        bbcodeToolbar.addColorSelect("Colours", colors, false);
    </script>
	    <br /><br/>
        <a class="new-button red-button cancel-icon" href="forum.php"><b><span></span>Cancel</b><i></i></a>
        <a id="topic-form-save" class="new-button green-button save-icon" href="#"><b><span></span>Save</b><i></i></a>
        </td>
        </tr>
        </table>
	</td>
</tr>

</table>
<div id="new-post-preview" style="display:none;">
</div>
<?php }
}elseif($row['topics'] == 2) {
	$stmt = $bdd->prepare("SELECT * FROM groups_memberships WHERE userid=:my_id AND groupid=:group_id AND member_rank='2' LIMIT 1");
$stmt->bindParam(':my_id', $user['id']);
$stmt->bindParam(':group_id', $_POST['groupId']);
$stmt->execute();

if($stmt->rowCount() > 0) { ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="group-postlist-list" id="group-postlist-list">
<tr>
    <td class="post-header-link" valign="top" style="width: 148px;"></td>
    <td class="post-header-name" valign="top"></td>
    <td align="right">
</tr>
<tr>
	<td colspan="3" class="post-list-row-container"><div id="new-topic-preview"></div></td>
</tr>

<tr class="new-topic-entry-label" id="new-topic-entry-label">
	<td class="new-topic-entry-label">Topic:</td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
	    <div class="post-list-content-element"><input type="text" size="50" id="new-topic-name"/></div>
	    </td>
	    </tr>
	    </table>
    </td>
</tr>
<tr class="topic-name-error">
    <td></td>
    <td colspan="2">
        <div id="topic-name-error"></div>
    </td>
</tr>

<tr id="new-post-entry-message" style="display:none;">
	<td class="new-post-entry-label"><div class="new-post-entry-label" id="new-post-entry-label">Message:</div></td>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" style="margin: 5px; width: 98%;">
		<tr>
		<td>
		<input type="hidden" id="edit-type"/>
		<input type="hidden" id="post-id"/>
        <a href="#" class="preview-post-link" id="topic-form-preview">Pr&eacute;voir &raquo;</a>
        <input type="hidden" id="spam-message" value="Spam detected!"/>
		<textarea id="post-message" class="new-post-entry-message" rows="5" name="message" ></textarea>
    <script type="text/javascript">
        bbcodeToolbar = new Control.TextArea.ToolBar.BBCode("post-message");
        bbcodeToolbar.toolbar.toolbar.id = "bbcode_toolbar";
        var colors = { "red" : ["#d80000", "Rouge"],
            "orange" : ["#fe6301", "Orange"],
            "yellow" : ["#ffce00", "Jaune"],
            "green" : ["#6cc800", "Vert"],
            "cyan" : ["#00c6c4", "Ciel"],
            "blue" : ["#0070d7", "Bleu"],
            "gray" : ["#828282", "Gris"],
            "black" : ["#000000", "Noir"]
        };
        bbcodeToolbar.addColorSelect("Couleurs", colors, false);
    </script>
	    <br /><br/>
        <a class="new-button red-button cancel-icon" href="forum.php"><b><span></span>Quitter</b><i></i></a>
        <a id="topic-form-save" class="new-button green-button save-icon" href="#"><b><span></span>Sauvegarder</b><i></i></a>
        </td>
        </tr>
        </table>
	</td>
</tr>

        </table>
	</td>
</tr>

</table>
<div id="new-post-preview" style="display:none;">
</div>
		<?php
		}
	}
?>