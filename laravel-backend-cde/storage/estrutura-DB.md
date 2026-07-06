Table tipo [headercolor: #175e7a] {
	id integer [pk, increment, not null]
	nome_tipo varchar [not null, unique]
}

Table fabricante [headercolor: #175e7a] {
	id integer [pk, increment, not null]
	nome_fabricante varchar [not null, unique]
}

Table localizacao [headercolor: #175e7a] {
	id integer [pk, increment, not null]
	localizacao_nome varchar [not null, unique]
}

Table Item_de_quantidade [headercolor: #175e7a] {
	id integer [pk, increment, not null]

	id_tipo integer [not null]
	id_fabricante integer [not null]
	id_localizacao integer [not null]

	quantidade integer [not null]
	observacao varchar

	Indexes {
		(id_tipo, id_fabricante, id_localizacao) [unique]
	}
}

Table Item_patrimoniado [headercolor: #175e7a] {
	id integer [pk, increment, not null]

	patrimonio integer [not null, unique]

	id_tipo integer [not null]
	id_fabricante integer [not null]
	id_localizacao integer [not null]

	observacao varchar
}

Ref: Item_de_quantidade.id_tipo > tipo.id
Ref: Item_de_quantidade.id_fabricante > fabricante.id
Ref: Item_de_quantidade.id_localizacao > localizacao.id

Ref: Item_patrimoniado.id_tipo > tipo.id
Ref: Item_patrimoniado.id_fabricante > fabricante.id
Ref: Item_patrimoniado.id_localizacao > localizacao.id