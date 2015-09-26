<h2>Enregistrer une liste de membres</h2>

<p>Copier ci-dessous le contenu d'un fichier csv</p>

<p>Le format des données doit respecter la syntaxe suivante</p>
<p>nom;prénom;date naissance;Lieu de naissance;sexe;adresse;code postal;ville;mail;téléphone fixe;gsm;</p>
<pre>
Papousse;Adrien;1970-08-25;Anderlecht;H;rue des kayakistes;2044;Kayakisteville;papousse.adrien@kayak.org;05/234.34.34;0494/23 32 66;Kayakisteville;
Papousse;Elise;2000-12-18;Chiny;F;rue des kayakistes;2044;Kayakisteville;;;;;
</pre>


<?php echo $this->Form->create(null,
array('url'=>'/ManageMembers/uploadMembers/'.$club
)); ?>
<table width="90%">
   <tr>
    <td colspan="3"><?php 
     
      echo $this->Form->input('club', array('options' => array($club),'style'=>"color:green;font-size:20px" ));
      ?></td>
   </tr>
   <tr>
      <td><?php 
      echo $this->Form->textarea('members', array('rows' => '20', 'cols' => '150','wrap'=>'off'));
      ?></td>
   </tr>
</table>
<div><input class="btn-green" type="submit" value="Envoyer" /></div>
</form>
