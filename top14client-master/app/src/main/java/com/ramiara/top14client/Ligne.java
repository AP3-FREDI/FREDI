package com.ramiara.top14client;
import android.util.Log;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Classe métier d'un club
 * Décrit les données d'un club
 */
public class Ligne {

    public int idligne;
    public String datligne;
    public int idmotif;
    public String libtrajet;
    public int nbkm ;
    public int mtkm ;
    public int mtpeage ;
    public int mtrepas ;
    public int mthebergement ;
    public int mttotal ;

    public String lib_motif ;

    public Ligne(JSONObject jsonObject) {
        try {
            idligne = jsonObject.getInt("id_ligne");
            datligne = jsonObject.getString("dat_ligne");
            idmotif = jsonObject.getInt("id_motif");
            libtrajet = jsonObject.getString("lib_trajet");
            nbkm = jsonObject.getInt("nb_km");
            mtkm = jsonObject.getInt("mt_km");
            mtpeage = jsonObject.getInt("mt_peage");
            mtrepas = jsonObject.getInt("mt_repas");
            mthebergement = jsonObject.getInt("mt_hebergement");
            mttotal = jsonObject.getInt("mt_total");
            lib_motif= jsonObject.getString("lib_motif");
        } catch (JSONException e) {
            Log.d(MainActivity.LOG_TAG,"Erreur lors de la conversion de l'objet JSON en objet Club");
            e.printStackTrace();
        }
    }

    /**
     * Convertit l'objet courant en array
     * @return le tableau
     */
    public String[] toArray() {
        String data[] = {
                Integer.toString(idligne),
                datligne,
                Integer.toString(idmotif),
                libtrajet,
                Integer.toString(nbkm),
                Integer.toString(mtkm),
                Integer.toString(mtpeage),
                Integer.toString(mtrepas),
                Integer.toString(mthebergement),
                Integer.toString(mttotal),
                lib_motif
        };
        return data;
    }

}
