package com.example.jubileueventos.retrofit;

import com.example.jubileueventos.modelDominio.AcaoEvento;
import com.example.jubileueventos.modelDominio.Evento;
import com.example.jubileueventos.modelDominio.Usuario;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.POST;

public interface EventoService {
    @POST("eventos/participantes/excluir")
    Call<Evento> removerInscricao(@Body AcaoEvento acaoEvento);

    @POST("eventos/participantes/inserir")
    Call<Evento> inscluirInscricao(@Body AcaoEvento acaoEvento);

    @POST("eventos/listar")
    Call<List<Evento>> listarEventos();
}
