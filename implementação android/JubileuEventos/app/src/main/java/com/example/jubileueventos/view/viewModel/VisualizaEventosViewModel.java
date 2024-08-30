package com.example.jubileueventos.view.viewModel;

import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.example.jubileueventos.modelDominio.AcaoEvento;
import com.example.jubileueventos.modelDominio.Evento;
import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.repository.EventoRepository;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class VisualizaEventosViewModel extends ViewModel {
    private EventoRepository eventoRepository;
    private MutableLiveData<List<Evento>> mListaEventos;

    private MutableLiveData<Boolean> mResultadoOperacao;

    private MutableLiveData<Boolean> mResultadoInscricao;

    public VisualizaEventosViewModel() {
        this.eventoRepository = new EventoRepository();
        this.mListaEventos = new MutableLiveData<>();
        this.mResultadoOperacao = new MutableLiveData<>();
        this.mResultadoInscricao = new MutableLiveData<>();
    }

    public MutableLiveData<List<Evento>> getListaEventos() {
        return mListaEventos;
    }

    public MutableLiveData<Boolean> getResultadoOperacao() {
        return mResultadoOperacao;
    }

    public MutableLiveData<Boolean> getResultadoInscricao() {
        return mResultadoInscricao;
    }

    public void obtemListaEventos() {
        this.eventoRepository.listarEventos(new Callback<List<Evento>>() {
            @Override
            public void onResponse(Call<List<Evento>> call, Response<List<Evento>> response) {
                mListaEventos.postValue(response.body());
            }

            @Override
            public void onFailure(Call<List<Evento>> call, Throwable t) {
                mListaEventos.postValue(null);
            }
        });
    }

    public void removerInscricao(Usuario usuario, Evento evento) {
        int idUsuario = usuario.getIdUsuario();
        int idEvento = evento.getIdEvento();

        AcaoEvento acaoEvento = new AcaoEvento(idUsuario, idEvento);
        this.eventoRepository.removerInscricao(acaoEvento, new Callback<Evento>() {
            @Override
            public void onResponse(Call<Evento> call, Response<Evento> response) {
                // trata resultado
                Evento evento = response.body();
                if (evento.getIdEvento() > 0) {
                    mResultadoOperacao.postValue(true);

                    // atualiza lista de eventos
                    obtemListaEventos();
                } else {
                    mResultadoOperacao.postValue(false);
                }
            }

            @Override
            public void onFailure(Call<Evento> call, Throwable t) {
                mResultadoOperacao.postValue(false);
            }
        });
    }

    public void incluirInscricao(Usuario usuario, Evento evento) {
        int idUsuario = usuario.getIdUsuario();
        int idEvento = evento.getIdEvento();

        AcaoEvento acaoEvento = new AcaoEvento(idUsuario, idEvento);
        this.eventoRepository.incluirInscricao(acaoEvento, new Callback<Evento>() {
            @Override
            public void onResponse(Call<Evento> call, Response<Evento> response) {
                // trata resultado
                Evento evento = response.body();
                if (evento.getIdEvento() > 0) {
                    mResultadoInscricao.postValue(true);

                    // atualiza lista de eventos
                    obtemListaEventos();
                } else {
                    mResultadoInscricao.postValue(false);
                }
            }

            @Override
            public void onFailure(Call<Evento> call, Throwable t) {
                mResultadoInscricao.postValue(false);
            }
        });
    }

    public void limpaEstadoOperacao () {
        this.mResultadoOperacao = new MutableLiveData<>();
        this.mResultadoInscricao = new MutableLiveData<>();
    }
}























