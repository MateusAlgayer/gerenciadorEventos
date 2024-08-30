package com.example.jubileueventos.modelDominio;

import java.io.Serializable;

public class Participacoes implements Serializable {
    private int idParticipante;
    private String nome;

    public Participacoes(int idParticipante, String nome) {
        this.idParticipante = idParticipante;
        this.nome = nome;
    }

    public Participacoes(String nome) {
        this.nome = nome;
    }

    public int getIdMarca() {
        return idParticipante;
    }

    public void setIdMarca(int idMarca) {
        this.idParticipante = idParticipante;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }
}
