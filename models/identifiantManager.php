<?php
include_once('bd.php');
include_once('identifiant.php');

class IdentifiantManager
{
    public $_msgError;

    public function __construct()
    {

    }

    public function searchIdentifiantsByOptions($options){

        try
                {
                    $search_key = $options["search_key"];
                    $search_options = $options["search_options"];

                    $identifiants = array(
                      "site_web" => array(),
                      "compte_messagerie" => array(),
                      "application" => array(),
                      "carte_bancaire" => array(),
                      "serveur" => array()
                    );

                    //$search_options contient 'site_web'
                    if (in_array("site_web",$search_options)){
                        $identifiants["site_web"] = $this->searchSiteWebIdentifiants($search_key);
                    }

                    //$search_options contient 'messagerie'
                    if (in_array("messagerie",$search_options)){
                        $identifiants["compte_messagerie"] = $this->searchMessagerieIdentifiants($search_key);
                    }

                    //$search_options contient 'application'
                    if (in_array("application",$search_options)){
                        $identifiants["application"] = $this->searchApplicationIdentifiants($search_key);
                    }

                    //$search_options contient 'carte_bancaire'
                    if (in_array("carte_bancaire",$search_options)){
                        $identifiants["carte_bancaire"] = $this->searchCarteBancaireIdentifiants($search_key);
                    }

                    //$search_options contient 'serveur'
                    if (in_array("serveur",$search_options)){
                        $identifiants["serveur"] = $this->searchServeurIdentifiants($search_key);
                    }

                    return $identifiants;

                }
                catch(Exception $e)
                {
                	$this->_msgError = "[CLS::IdentifiantManager][FCT::searchIdentifiantsByOptions] Erreur : ".$e->getMessage();

                	return $identifiants;
                }
    }

    public function searchSiteWebIdentifiants($search_key){
          try
          {
              $sql_site_web = "select sw.id as id_ident,ti.libelle_ident as libelle,sw.login, sw.mdp, sw.commentaire,tsw.libelle_type,sw.lien_conn from site_web sw inner join type_identifiant ti on sw.id_type_identifiant = ti.id_ident inner join type_site_web tsw on sw.id_type_site_web = tsw.id_type where ti.libelle_ident like '%".$search_key."%'";

              $bdMan = new BdManager();

              $entetes = array("id_ident","libelle","login","mdp","commentaire","libelle_type","lien_conn");

              $res = $bdMan->executeSelect($sql_site_web,$entetes);

              $identifiants = array();

              if (count($res) > 0)
              {

                  for ($i = 0 ; $i < count($res) ; $i++)
                  {
                      $currentIdent = array(
                          "id_ident" => $res[$i]["id_ident"],
                          "libelle" => $res[$i]["libelle"],
                          "login" => $res[$i]["login"],
                          "mdp" => $res[$i]["mdp"],
                          "commentaire" => $res[$i]["commentaire"],
                          "libelle_type" => $res[$i]["libelle_type"],
                          "lien_conn" => $res[$i]["lien_conn"]
                      );


                      $identifiants[] = $currentIdent;

                  }

              }
              else
              {
                  $this->_msgError = "[CLS::IdentifiantManager][FCT::searchSiteWebIdentifiants] Aucune données dans la table ! ";
              }
          } catch(Exception $e) {
                $this->_msgError = "[CLS::IdentifiantManager][FCT::searchSiteWebIdentifiants] Erreur : ".$e->getMessage();
                return $identifiants;
          }

          return $identifiants;
    }

    public function searchMessagerieIdentifiants($search_key){
          try
          {
              $sql_messagerie = "select ti.id_ident as id_ident,ti.libelle_ident as libelle,cm.nom_messagerie, cm.login, cm.mdp, cm.commentaire, cm.lien_conn from compte_messagerie cm inner join type_identifiant ti on cm.id_type = ti.id_ident where ti.libelle_ident like '%".$search_key."%'";

              $bdMan = new BdManager();

              $entetes = array("id_ident","libelle",'nom_messagerie',"login","mdp","commentaire","lien_conn");

              $res = $bdMan->executeSelect($sql_messagerie,$entetes);

              $identifiants = array();

              if (count($res) > 0)
              {

                  for ($i = 0 ; $i < count($res) ; $i++)
                  {
                      $currentIdent = array(
                          "id_ident" => $res[$i]["id_ident"],
                          "libelle" => $res[$i]["libelle"],
                          "nom_messagerie" => $res[$i]["nom_messagerie"],
                          "login" => $res[$i]["login"],
                          "mdp" => $res[$i]["mdp"],
                          "commentaire" => $res[$i]["commentaire"],
                          "lien_conn" => $res[$i]["lien_conn"]
                      );


                      $identifiants[] = $currentIdent;

                  }

              }
              else
              {
                  $this->_msgError = "[CLS::IdentifiantManager][FCT::searchMessagerieIdentifiants] Aucune données dans la table ! ";
              }
          } catch(Exception $e) {
                $this->_msgError = "[CLS::IdentifiantManager][FCT::searchMessagerieIdentifiants] Erreur : ".$e->getMessage();
                return $identifiants;
          }

          return $identifiants;
    }
    public function searchApplicationIdentifiants($search_key){
        try
        {
          $sql_application = "select app.id_app, tident.id_ident, tident.libelle_ident as libelle, tapp.libelle_type_app as type_application, app.login, app.mdp, app.commentaire, app.version_app, app.cle_authen from application app inner join type_application tapp on app.id_type_app = tapp.id_type_app inner join type_identifiant tident on tident.id_ident = app.id_type where tident.libelle_ident like '%".$search_key."%'";

          $bdMan = new BdManager();

          $entetes = array("id_ident","libelle", "type_application", "login", "mdp", "commentaire", "version_app", "cle_authen");

          $res = $bdMan->executeSelect($sql_application,$entetes);

          $identifiants = array();

          if (count($res) > 0)
          {

              for ($i = 0 ; $i < count($res) ; $i++)
              {
                  $currentIdent = array(
                      "id_ident" => $res[$i]["id_ident"],
                      "libelle" => $res[$i]["libelle"],
                      "type_application" => $res[$i]["type_application"],
                      "login" => $res[$i]["login"],
                      "mdp" => $res[$i]["mdp"],
                      "commentaire" => $res[$i]["commentaire"],
                      "version_app" => $res[$i]["version_app"],
                      "cle_authen" => $res[$i]["cle_authen"]
                  );


                  $identifiants[] = $currentIdent;

              }

          }
          else
          {
              $this->_msgError = "[CLS::IdentifiantManager][FCT::searchApplicationIdentifiants] Aucune données dans la table ! ";
          }
      } catch(Exception $e) {
            $this->_msgError = "[CLS::IdentifiantManager][FCT::searchApplicationIdentifiants] Erreur : ".$e->getMessage();
            return $identifiants;
      }
      return $identifiants;
    }

    public function searchCarteBancaireIdentifiants($search_key){
        try
        {
          $sql_carte_bancaire = "select ti.id_ident, ti.libelle_ident as libelle, cb.banque, cb.numero, cb.date_exp, cb.commentaire from carte_bancaire cb inner join type_identifiant ti on cb.id_type = ti.id_ident where ti.libelle_ident like '%".$search_key."%'";

          $bdMan = new BdManager();

          $entetes = array("id_ident", "libelle", "banque", "numero", "date_exp", "commentaire");

          $res = $bdMan->executeSelect($sql_carte_bancaire,$entetes);

          $identifiants = array();

          if (count($res) > 0)
          {

              for ($i = 0 ; $i < count($res) ; $i++)
              {
                  $currentIdent = array(
                      "id_ident" => $res[$i]["id_ident"],
                      "libelle" => $res[$i]["libelle"],
                      "banque" => $res[$i]["banque"],
                      "numero" => $res[$i]["numero"],
                      "date_exp" => $res[$i]["date_exp"],
                      "commentaire" => $res[$i]["commentaire"]
                  );


                  $identifiants[] = $currentIdent;

              }

          }
          else
          {
              $this->_msgError = "[CLS::IdentifiantManager][FCT::searchCarteBancaireIdentifiants] Aucune données dans la table ! ";
          }
      } catch(Exception $e) {
            $this->_msgError = "[CLS::IdentifiantManager][FCT::searchCarteBancaireIdentifiants] Erreur : ".$e->getMessage();
            return $identifiants;
      }
      return $identifiants;

    }

    public function searchServeurIdentifiants($search_key){
        try
        {
          $sql_serveur = "select ti.id_ident, ti.libelle_ident as libelle, ts.libelle_type_serveur, s.login, s.mdp, s.commentaire, s.nom_os, s.version_os, s.adresse_ip, s.lien_serveur from serveur s inner join type_identifiant ti on s.id_type = ti.id_ident inner join type_serveur ts on s.id_type_serveur = ts.id_type_serveur where ti.libelle_ident like '%".$search_key."%'";

          $bdMan = new BdManager();

          $entetes = array("id_ident", "libelle", "libelle_type_serveur", "login", "mdp", "commentaire", "nom_os", "version_os", "adresse_ip", "lien_serveur");

          $res = $bdMan->executeSelect($sql_serveur,$entetes);

          $identifiants = array();

          if (count($res) > 0)
          {

              for ($i = 0 ; $i < count($res) ; $i++)
              {
                  $currentIdent = array(
                      "id_ident" => $res[$i]["id_ident"],
                      "libelle" => $res[$i]["libelle"],
                      "libelle_type_serveur" => $res[$i]["libelle_type_serveur"],
                      "login" => $res[$i]["login"],
                      "mdp" => $res[$i]["mdp"],
                      "commentaire" => $res[$i]["commentaire"],
                      "nom_os" => $res[$i]["nom_os"],
                      "version_os" => $res[$i]["version_os"],
                      "adresse_ip" => $res[$i]["adresse_ip"],
                      "lien_serveur" => $res[$i]["lien_serveur"]
                  );


                  $identifiants[] = $currentIdent;

              }

          }
          else
          {
              $this->_msgError = "[CLS::IdentifiantManager][FCT::searchCarteBancaireIdentifiants] Aucune données dans la table ! ";
          }
      } catch(Exception $e) {
            $this->_msgError = "[CLS::IdentifiantManager][FCT::searchCarteBancaireIdentifiants] Erreur : ".$e->getMessage();
            return $identifiants;
      }
      return $identifiants;
    }

    public function getAllIdentifiants()
    {
        try
        {

            $identifiants = array(
              "site_web" => array(),
              "compte_messagerie" => array(),
              "application" => array(),
              "carte_bancaire" => array(),
              "serveur" => array()
            );

            $identifiants["site_web"] = $this->getAllSiteWebIdentifiants();
            $identifiants["compte_messagerie"] = $this->getAllCptMessagerieIdentifiants();
            $identifiants["application"] = $this->getAllApplicationsIdentifiants();
            $identifiants["carte_bancaire"] = $this->getAllCarteBancaireIdentifiants();
            $identifiants["serveur"] = $this->getAllServeursIdentifiants();


            return $identifiants;

        }
        catch(Exception $e)
        {
        	$this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Erreur : ".$e->getMessage();

        	return $identifiants;
        }

    }

    private function getAllApplicationsIdentifiants()
    {
      try
      {
          $sql = "select T.id_ident, T.libelle_ident as libelle, TA.libelle_type_app as type, A.id_app,A.nom_app, A.login, A.mdp, A.cle_authen, A.commentaire, A.version_app from application A, type_identifiant T, type_application TA where A.id_type = T.id_ident and TA.id_type_app = A.id_type_app";

          $bdMan = new BdManager();

          $entetes = array("id_ident","libelle","type","id_app","nom_app","login","mdp","cle_authen","commentaire","version_app");

          $res = $bdMan->executeSelect($sql,$entetes);

          $identifiants = array();

          if (count($res) > 0)
          {

              for ($i = 0 ; $i < count($res) ; $i++)
              {

                  $currentIdent = array(
                      "id_ident" => $res[$i]["id_ident"],
                      "libelle" => $res[$i]["libelle"],
                      "type" => $res[$i]["type"],
                      "id_app" => $res[$i]["id_app"],
                      "nom_app" => $res[$i]["nom_app"],
                      "login" => $res[$i]["login"],
                      "mdp" => $res[$i]["mdp"],
                      "cle_authen" => $res[$i]["cle_authen"],
                      "commentaire" => $res[$i]["commentaire"],
                      "version_app" => $res[$i]["version_app"]
                  );


                  $identifiants[] = $currentIdent;

              }

          }
          else
          {
              $this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Aucune données dans la table ! ";
          }

          return $identifiants;

      }
      catch(Exception $e)
      {
        $this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Erreur : ".$e->getMessage();

        return $identifiants;
      }

    }

    private function getAllCptMessagerieIdentifiants()
    {
        try
        {
            $sql = "select T.id_ident, T.libelle_ident as libelle, C.nom_messagerie as messagerie, C.lien_conn as lien, C.login as login, C.mdp, C.commentaire from compte_messagerie C , type_identifiant T where C.id_type = T.id_ident";

            $bdMan = new BdManager();

            $entetes = array("id_ident","libelle", "messagerie", "lien", "login", "mdp", "commentaire");

            $res = $bdMan->executeSelect($sql,$entetes);

            $identifiants = array();

            if (count($res) > 0)
            {

                for ($i = 0 ; $i < count($res) ; $i++)
                {
                    $currentIdent = array(
                        "id_ident" => $res[$i]["id_ident"],
                        "libelle" => $res[$i]["libelle"],
                        "messagerie" => $res[$i]["messagerie"],
                        "lien" => $res[$i]["lien"],
                        "login" => $res[$i]["login"],
                        "mdp" => $res[$i]["mdp"],
                        "commentaire" => $res[$i]["commentaire"]
                    );

                    $identifiants[] = $currentIdent;

                }

            }
            else
            {
                $this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Aucune données dans la table ! ";
            }

            return $identifiants;

        }
        catch(Exception $e)
        {
          $this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Erreur : ".$e->getMessage();

          return $identifiants;
        }
    }

    private function getAllCarteBancaireIdentifiants()
    {
        try
        {
            $sql = "select T.id_ident, T.libelle_ident as libelle,C.id_carte, C.banque, C.numero, C.date_exp, C.commentaire, T.icon_type_ident from carte_bancaire C, type_identifiant T where C.id_type = T.id_ident";

            $bdMan = new BdManager();

            $entetes = array("id_ident", "libelle","id_carte","banque","numero","date_exp","commentaire","icon_type_ident");

            $res = $bdMan->executeSelect($sql,$entetes);

            $identifiants = array();

            if (count($res) > 0)
            {

                for ($i = 0 ; $i < count($res) ; $i++)
                {

                    $currentIdent = array(
                        "id_ident" => $res[$i]["id_ident"],
                        "libelle" => $res[$i]["libelle"],
                        "id_carte" => $res[$i]["id_carte"],
                        "banque" => $res[$i]["banque"],
                        "numero" => $res[$i]["numero"],
                        "date_exp" => $res[$i]["date_exp"],
                        "commentaire" => $res[$i]["commentaire"],
                        "icon_type_ident" => $res[$i]["icon_type_ident"]
                    );

                    $identifiants[] = $currentIdent;

                }

            }
            else
            {
                $this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Aucune données dans la table ! ";
            }

            return $identifiants;

        }
        catch(Exception $e)
        {
          $this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Erreur : ".$e->getMessage();

          return $identifiants;
        }
    }

    private function getAllServeursIdentifiants()
    {
        try
        {
            $sql = "select T.id_ident, T.libelle_ident as libelle,S.id_serveur, TS.libelle_type_serveur,TS.icon_type_serveur, S.lien_serveur, S.adresse_ip, S.login, S.mdp, S.commentaire, S.nom_os, S.version_os from serveur S, type_serveur TS, type_identifiant T where S.id_type = T.id_ident and S.id_type_serveur = TS.id_type_serveur";

            $bdMan = new BdManager();

            $entetes = array("id_ident","libelle","id_serveur","libelle_type_serveur","icon_type_serveur","lien_serveur","adresse_ip","login","mdp","commentaire","nom_os","version_os");

            $res = $bdMan->executeSelect($sql,$entetes);

            $identifiants = array();

            if (count($res) > 0)
            {

                for ($i = 0 ; $i < count($res) ; $i++)
                {

                    $currentIdent = array(
                        "id_ident" => $res[$i]["id_ident"],
                        "libelle" => $res[$i]["libelle"],
                        "id_serveur" => $res[$i]["id_serveur"],
                        "libelle_type_serveur" => $res[$i]["libelle_type_serveur"],
                        "icon_type_serveur" => $res[$i]["icon_type_serveur"],
                        "lien_serveur" => $res[$i]["lien_serveur"],
                        "adresse_ip" => $res[$i]["adresse_ip"],
                        "login" => $res[$i]["login"],
                        "mdp" => $res[$i]["mdp"],
                        "commentaire" => $res[$i]["commentaire"],
                        "nom_os" => $res[$i]["nom_os"],
                        "version_os" => $res[$i]["version_os"]
                    );

                    $identifiants[] = $currentIdent;

                }

            }
            else
            {
                $this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Aucune données dans la table ! ";
            }

            return $identifiants;

        }
        catch(Exception $e)
        {
          $this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Erreur : ".$e->getMessage();

          return $identifiants;
        }
    }

    private function getAllSiteWebIdentifiants()
    {
      try
      {
          $sql = "select T.id_ident,T.libelle_ident as libelle , TS.libelle_type as type, S.lien_conn as lien, S.login as login, S.mdp , S.commentaire from site_web S, type_identifiant T, type_site_web TS where S.id_type_identifiant = T.id_ident and S.id_type_site_web = TS.id_type";

          $bdMan = new BdManager();

          $entetes = array("id_ident","libelle","type","lien","login","mdp","commentaire");

          $res = $bdMan->executeSelect($sql,$entetes);

          $identifiants = array();

          if (count($res) > 0)
          {

              for ($i = 0 ; $i < count($res) ; $i++)
              {

                  $currentIdent = array(
                    "id_ident" => $res[$i]["id_ident"],
                    "libelle" => $res[$i]["libelle"],
                    "type" => $res[$i]["type"],
                    "lien" => $res[$i]["lien"],
                    "login" => $res[$i]["login"],
                    "mdp" => $res[$i]["mdp"],
                    "commentaire" => $res[$i]["commentaire"]
                  );

                  $identifiants[] = $currentIdent;

              }

          }
          else
          {
              echo "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Aucune données dans la table ! ";
          }

          return $identifiants;

      }
      catch(Exception $e)
      {
        $this->_msgError = "[CLS::IdentifiantManager][FCT::getAllIdentifiants] Erreur : ".$e->getMessage();

        return $identifiants;
      }

    }
}

 ?>
