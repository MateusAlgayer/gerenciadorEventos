package com.example.jubileueventos.view.fragments;

import androidx.lifecycle.Observer;
import androidx.lifecycle.ViewModelProvider;

import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.navigation.Navigation;
import androidx.recyclerview.widget.DefaultItemAnimator;
import androidx.recyclerview.widget.LinearLayoutManager;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import com.example.jubileueventos.R;
import com.example.jubileueventos.modelDominio.Evento;
import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.view.adapter.EventoAdapter;
import com.example.jubileueventos.view.viewModel.InformacoesViewModel;
import com.example.jubileueventos.view.viewModel.VisualizaEventosViewModel;
import com.example.jubileueventos.databinding.FragmentVisualizaEventosBinding;

import java.util.ArrayList;
import java.util.List;

public class VisualizaEventosFragment extends Fragment {

    private VisualizaEventosViewModel mViewModel;
    FragmentVisualizaEventosBinding binding;
    EventoAdapter eventoAdapter;

    InformacoesViewModel informacoesViewModel;

    public VisualizaEventosFragment() {
        // necessário para o bottomNavigation
    }

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        binding = FragmentVisualizaEventosBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        mViewModel = new ViewModelProvider(this).get(VisualizaEventosViewModel.class);

        //precaução, definir adapter do recycler
        atualizaListaEventos(new ArrayList<>());

        // chamando a obtenção da lista
        mViewModel.obtemListaEventos();

        // definindo observador da lista de eventos
        mViewModel.getListaEventos().observe(getViewLifecycleOwner(), observaListaEventos);

        // observador da remoção
        mViewModel.getResultadoOperacao().observe(getViewLifecycleOwner(), observaExclusaoEvento);

        // observador da inscrição
        mViewModel.getResultadoInscricao().observe(getViewLifecycleOwner(), observaInscricaoEvento);
    }

    // observador da lista de eventos
    Observer<List<Evento>> observaListaEventos = new Observer<List<Evento>>() {
        @Override
        public void onChanged(List<Evento> eventos) {
            atualizaListaEventos(eventos);
        }
    };

    Observer<Boolean> observaExclusaoEvento = new Observer<Boolean>() {
        @Override
        public void onChanged(Boolean aBoolean) {
            if (aBoolean) {
                Toast.makeText(getContext(), "Inscrição no evento removida com sucesso!", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(getContext(), "Erro: Inscrição no evento não removida.", Toast.LENGTH_SHORT).show();
            }
        }
    };

    Observer<Boolean> observaInscricaoEvento = new Observer<Boolean>() {
        @Override
        public void onChanged(Boolean aBoolean) {
            if (aBoolean) {
                Toast.makeText(getContext(), "Inscrição no evento realizada com sucesso!", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(getContext(), "Erro: Inscrição no evento não realizada.", Toast.LENGTH_SHORT).show();
            }
        }
    };

    // método responsável por carregar a lista de eventos no recyclerview
    public void atualizaListaEventos(List<Evento> listaEventos) {
        // quando recebe nulo (após a exclusão, por exemplo, precisa carregar a tela)
        if (listaEventos == null) {
            // instanciando uma lista vazia
            listaEventos = new ArrayList<>();
        }

        informacoesViewModel = new ViewModelProvider(getActivity()).get(InformacoesViewModel.class);
        Usuario usuario = informacoesViewModel.obtemUsuarioLogado();

        eventoAdapter = new EventoAdapter(listaEventos, trataCliqueItem, trataCliqueRemoverInscricao, trataCliqueInscricao, usuario);
        binding.rvVisualizaEventos.setLayoutManager(new LinearLayoutManager(requireContext()));
        binding.rvVisualizaEventos.setItemAnimator(new DefaultItemAnimator());
        binding.rvVisualizaEventos.setAdapter(eventoAdapter);

    }

    EventoAdapter.EventoOnClickListener trataCliqueItem = new EventoAdapter.EventoOnClickListener() {
        @Override
        public void onClickEvento(View view, int position, Usuario usuario, Evento evento) {
            // programar ação de clique
        }
    };

    EventoAdapter.EventoOnClickListener trataCliqueRemoverInscricao = new EventoAdapter.EventoOnClickListener() {
        @Override
        public void onClickEvento(View view, int position, Usuario usuario, Evento evento) {
            // programar ação de remover inscricao
            mViewModel.removerInscricao(usuario,evento);
        }
    };

    EventoAdapter.EventoOnClickListener trataCliqueInscricao = new EventoAdapter.EventoOnClickListener() {
        @Override
        public void onClickEvento(View view, int position, Usuario usuario,Evento evento) {
            mViewModel.incluirInscricao(usuario,evento);
        }
    };

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;

        // limpando controle da operação da exclusão/inscrição
        mViewModel.limpaEstadoOperacao();
    }
}













