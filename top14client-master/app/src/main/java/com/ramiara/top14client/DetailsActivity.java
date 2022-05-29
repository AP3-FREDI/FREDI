package com.ramiara.top14client;
//
// Top 14 client
//
// Détails du club
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.TextView;

public class    DetailsActivity extends AppCompatActivity {

    Intent myIntent;
    TextView myViewnote;
    TextView myViewdateligne;
    TextView myViewmotif;
    TextView myViewtrajet;
    TextView myViewkmparcourus;
    TextView myViewmttrajet;
    TextView myViewmtpeage;
    TextView myViewrepas;
    TextView myViewhebergement;
    TextView myViewmttotal;

    TextView myViewId;
    TextView myViewNom;
    TextView myViewCouleurs;
    TextView myViewStade;
    TextView myViewEcusson;
    TextView myViewClassement;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        // Récupère les données à afficher
        myIntent = getIntent();
        String myData[] = myIntent.getStringArrayExtra(MyAsyncTask.EXTRA_MESSAGE);

        // Affiche les données dans le layout


        myViewnote = (TextView) findViewById(R.id.tv_note);
        myViewnote.setText("note : " + myData[5]);

        myViewdateligne = (TextView) findViewById(R.id.tv_dateligne);
        myViewdateligne.setText("date ligne : " + myData[2]);



        myViewtrajet = (TextView) findViewById(R.id.tv_trajet);
        myViewtrajet.setText("trajet : " + myData[3]);

        myViewkmparcourus = (TextView) findViewById(R.id.tv_kmparcourus);
        myViewkmparcourus.setText("kmparcourus : " + myData[4]);

        myViewmttrajet = (TextView) findViewById(R.id.tv_mttrajet);
        myViewmttrajet.setText("montant trajet : " + myData[5]);


        myViewmtpeage = (TextView) findViewById(R.id.tv_mtpeage);
        myViewmtpeage.setText("montant péage : " + myData[6]);

        myViewrepas = (TextView) findViewById(R.id.tv_hebergement);
        myViewrepas.setText("montant repas : " + myData[7]);


        myViewhebergement = (TextView) findViewById(R.id.tv_hebergement);
        myViewhebergement.setText("montant hebergement : " + myData[8]);

        myViewmttotal = (TextView) findViewById(R.id.tv_mttotal);
        myViewmttotal.setText("montant total : " + myData[9]);


        myViewNom = (TextView) findViewById(R.id.tv_nom);
        myViewNom.setText(myData[1]);

/*
   myViewmotif = (TextView) findViewById(R.id.tv_motif);
        myViewmotif.setText("motif : " + myData[12]);


*/


        myViewId = (TextView) findViewById(R.id.tv_id);
        myViewId.setText("ID : " + myData[0]);

        myViewNom = (TextView) findViewById(R.id.tv_nom);
        myViewNom.setText(myData[1]);

        myViewCouleurs = (TextView) findViewById(R.id.tv_couleurs);
        myViewCouleurs.setText("Couleurs : " + myData[2]);

        myViewStade = (TextView) findViewById(R.id.tv_stade);
        myViewStade.setText("Stade : " + myData[3]);

        myViewEcusson = (TextView) findViewById(R.id.tv_ecusson);
        myViewEcusson.setText("Ecusson : " + myData[4]);

        myViewClassement = (TextView) findViewById(R.id.tv_classement);
        myViewClassement.setText("Classement : " + myData[5]);


        myViewClassement = (TextView) findViewById(R.id.tv_classement);
        myViewClassement.setText("Classement : " + myData[5]);

        myViewClassement = (TextView) findViewById(R.id.tv_classement);
        myViewClassement.setText("Classement : " + myData[5]);

        myViewClassement = (TextView) findViewById(R.id.tv_classement);
        myViewClassement.setText("Classement : " + myData[5]);
    }
}
