var Person = {
    nom: 'Aubert',
    prenom: 'Jean-Luc',
    age: 49,
    qualite: 'Formateur',

    getPerson: function(){
        return this.prenom + ' ' + this.nom + ' (' + this.qualite +')';
    },

    getAge: function(){
        return this.age;
    },

    setQualite: function(qualite){
        this.qualite = qualite;
        return this;
    }
};

