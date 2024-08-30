package com.example.jubileueventos.modelDominio;

import java.io.Serializable;
import java.util.Date;

public class Evento implements Serializable {
    private int idEvento;
    private String titulo;
    private String descricao;
    private String local;
    private Date data;

    private String participantes_id;

    public Evento(int idEvento, String titulo, String descricao, String local, Date data, String participantes_id) {
        this.idEvento = idEvento;
        this.titulo = titulo;
        this.descricao = descricao;
        this.local = local;
        this.data = data;
        this.participantes_id = participantes_id;
    }

    public Evento(String titulo, String descricao, String local, Date data, String participantes_id) {
        this.titulo = titulo;
        this.descricao = descricao;
        this.local = local;
        this.data = data;
        this.participantes_id = participantes_id;
    }

    public int getIdEvento() {
        return idEvento;
    }

    public void setIdEvento(int idEvento) {
        this.idEvento = idEvento;
    }

    public String getTitulo() {
        return titulo;
    }

    public void setTitulo(String titulo) {
        this.titulo = titulo;
    }

    public String getDescricao() {
        return descricao;
    }

    public void setDescricao(String descricao) {
        this.descricao = descricao;
    }

    public String getLocal() {
        return local;
    }

    public void setLocal(String local) {
        this.local = local;
    }

    public Date getData() {
        return data;
    }

    public void setData(Date data) {
        this.data = data;
    }

    public String getParticipantes() {
        return participantes_id;
    }

    public void setParticipantes(String participantes) {
        this.participantes_id = participantes_id;
    }
}
