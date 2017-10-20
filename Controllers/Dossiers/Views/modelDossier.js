class Dossier{
    id = null;
    nom = null;
    portable = null;
    email = null;

    constructor(){}

    setId(id){
        this.id = id;
        return this;
    }

    getId(){
        return this.id;
    }

    setNom(nom){
        this.nom = nom;
        return this;
    }

    getNom(){
        return this.nom;
    }
}