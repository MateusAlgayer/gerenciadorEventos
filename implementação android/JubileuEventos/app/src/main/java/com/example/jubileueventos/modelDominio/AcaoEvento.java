package com.example.jubileueventos.modelDominio;

public class AcaoEvento {
    private int idUsuario;
    private int idEvento;

    // Construtor
    public AcaoEvento(int idUsuario, int idEvento) {
        this.idUsuario = idUsuario;
        this.idEvento = idEvento;
    }

    // Getters e Setters
    public int getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(int idUsuario) {
        this.idUsuario = idUsuario;
    }

    public int getIdEvento() {
        return idEvento;
    }

    public void setIdEvento(int idEvento) {
        this.idEvento = idEvento;
    }

}
