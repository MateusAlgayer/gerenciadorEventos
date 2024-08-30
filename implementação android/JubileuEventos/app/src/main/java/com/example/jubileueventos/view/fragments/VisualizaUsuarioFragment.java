package com.example.jubileueventos.view.fragments;

import androidx.lifecycle.Observer;
import androidx.lifecycle.ViewModelProvider;

import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.jubileueventos.databinding.FragmentVisualizaUsuarioBinding;
import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.view.viewModel.InformacoesViewModel;
import com.example.jubileueventos.view.viewModel.VisualizaUsuarioViewModel;

public class VisualizaUsuarioFragment extends Fragment {

    private VisualizaUsuarioViewModel mViewModel;

    FragmentVisualizaUsuarioBinding binding;

    InformacoesViewModel informacoesViewModel;

    public VisualizaUsuarioFragment() {
        // necessário para o bottomNavigation
    }
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        binding = FragmentVisualizaUsuarioBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        mViewModel = new ViewModelProvider(this).get(VisualizaUsuarioViewModel.class);

        // obtendo o viewmodel de compartolhamento das informações
        informacoesViewModel = new ViewModelProvider(getActivity()).get(InformacoesViewModel.class);

        // obtendo o usuario logado
        Usuario usuario = informacoesViewModel.obtemUsuarioLogado();

        // definindo o usuario logado
        mViewModel.setUsuario(usuario);

        // observador do ususario
        mViewModel.getUsuario().observe(getViewLifecycleOwner(),observaUsuario);
    }

    // observar o usuario
    Observer<Usuario> observaUsuario = new Observer<Usuario>() {
        @Override
        public void onChanged(Usuario usuario) {
            carregaVisualizacaoUsuario(usuario);
        }
    };

   @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }

    public void carregaVisualizacaoUsuario(Usuario usuario) {
        binding.tvUsuarioVisualizaNome.setText(usuario.getNome());
        binding.tvUsuarioVisualizaEmail.setText(usuario.getEmail());
        binding.tvUsuarioVisualizaLogin.setText(usuario.getLogin());
    }

}