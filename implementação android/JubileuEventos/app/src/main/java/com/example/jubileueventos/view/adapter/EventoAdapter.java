package com.example.jubileueventos.view.adapter;

import android.annotation.SuppressLint;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.RecyclerView;


import com.example.jubileueventos.databinding.ItemListRowEventoBinding;
import com.example.jubileueventos.modelDominio.Evento;
import com.example.jubileueventos.modelDominio.Usuario;
import com.example.jubileueventos.view.viewModel.InformacoesViewModel;


import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;

public class EventoAdapter extends RecyclerView.Adapter<EventoAdapter.MyViewHolder> {
    private List<Evento> listaEventos;
    private EventoAdapter.EventoOnClickListener EventoOnClickListener;

    private EventoAdapter.EventoOnClickListener EventoOnDeleteClickListener;

    private EventoAdapter.EventoOnClickListener EventoOnAtualizarClickListener;

    private Usuario usuarioLogado;

    public EventoAdapter(List<Evento> listaEventos, EventoAdapter.EventoOnClickListener EventoOnClickListener, EventoAdapter.EventoOnClickListener EventoOnDeleteClickListener, EventoAdapter.EventoOnClickListener EventoOnAtualizarClickListener,
                         Usuario usuarioLogado) {
        this.listaEventos = listaEventos;
        this.EventoOnClickListener = EventoOnClickListener;
        this.EventoOnDeleteClickListener = EventoOnDeleteClickListener;
        this.EventoOnAtualizarClickListener = EventoOnAtualizarClickListener;
        this.usuarioLogado = usuarioLogado;
    }

    @Override
    public EventoAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        ItemListRowEventoBinding itemListRowBinding = ItemListRowEventoBinding.inflate(LayoutInflater.from(parent.getContext()), parent, false);
        return new EventoAdapter.MyViewHolder(itemListRowBinding);
    }

    @Override
    public void onBindViewHolder(final EventoAdapter.MyViewHolder holder, @SuppressLint("RecyclerView") final int position) {
        Evento evento = listaEventos.get(position);
        holder.itemListRowBinding.tvItemNome.setText(evento.getTitulo());
        holder.itemListRowBinding.tvItemDescricao.setText(evento.getDescricao());
        holder.itemListRowBinding.tvItemLocal.setText("Local: " + evento.getLocal());

        SimpleDateFormat formatter = new SimpleDateFormat("dd/MM/yyyy");
        Date date = evento.getData();
        String formattedDate = formatter.format(date);
        holder.itemListRowBinding.tvItemData.setText("Data: " + formattedDate);

        String participantes = evento.getParticipantes();
        String codigo =  String.valueOf(usuarioLogado.getIdUsuario());

        if (("," + participantes + ",").contains("," + codigo + ",")) {
            // Inscrito
            holder.itemListRowBinding.ivInscricao.setVisibility(View.GONE);
            holder.itemListRowBinding.ivExcluir.setVisibility(View.VISIBLE);
        } else {
            // Não está inscrito
            holder.itemListRowBinding.ivInscricao.setVisibility(View.VISIBLE);
            holder.itemListRowBinding.ivExcluir.setVisibility(View.GONE);
        }

        // tratando o clique no item
        if (EventoOnClickListener != null) {
            holder.itemListRowBinding.getRoot().setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    EventoOnClickListener.onClickEvento(holder.itemView, position, usuarioLogado, evento);
                }
            });
        }
        // tratando o clique de remover inscrição
        if (EventoOnDeleteClickListener != null) {
            holder.itemListRowBinding.ivExcluir.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    EventoOnDeleteClickListener.onClickEvento(holder.itemView, position, usuarioLogado, evento);
                }
            });
        }

        // tratando o clique de atualizar
        if (EventoOnAtualizarClickListener != null) {
            holder.itemListRowBinding.ivInscricao.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    EventoOnAtualizarClickListener.onClickEvento(holder.itemView, position, usuarioLogado, evento);
                }
            });
        }
    }

    @Override
    public int getItemCount() {
        return listaEventos.size();
    }

    public class MyViewHolder extends RecyclerView.ViewHolder {
        public  ItemListRowEventoBinding itemListRowBinding;
        public MyViewHolder(ItemListRowEventoBinding itemListRowBinding) {
            super(itemListRowBinding.getRoot());
            this.itemListRowBinding = itemListRowBinding;
        }
    }

    public interface EventoOnClickListener {
        public void onClickEvento(View view, int position, Usuario usuario, Evento evento);
    }

}