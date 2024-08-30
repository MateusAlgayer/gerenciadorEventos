package com.example.jubileueventos.repository;

import com.example.jubileueventos.modelDominio.AcaoEvento;
import com.example.jubileueventos.modelDominio.Evento;
import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.retrofit.ClienteRetrofit;
import com.example.jubileueventos.retrofit.EventoService;

import java.util.List;

import retrofit2.Callback;

public class EventoRepository {
    private  final EventoService eventoService = ClienteRetrofit.getInstance().create(EventoService.class);

    public void removerInscricao(AcaoEvento acaoEvento, Callback<Evento> callback) {
        eventoService.removerInscricao(acaoEvento).enqueue(callback);
    }

    public void incluirInscricao(AcaoEvento acaoEvento, Callback<Evento> callback) {
        eventoService.inscluirInscricao(acaoEvento).enqueue(callback);
    }

    public void listarEventos(Callback<List<Evento>> callback) {
        eventoService.listarEventos().enqueue(callback);
    }
}
