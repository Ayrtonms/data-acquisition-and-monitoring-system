package bean.user;

import data.Data;
import data.usuarios;

import javax.faces.bean.ManagedBean;
import javax.faces.bean.ViewScoped;
import javax.faces.context.FacesContext;
import javax.faces.application.FacesMessage;

@ManagedBean(name = "userBean")
@ViewScoped
public class UserBean {
	private Data data = Data.getInstance();

	private int id_usuario;

	private String nome;

	private String login;

	private String senha;

	private String confirmar;

	private boolean admin;

	public int getId_usuario() {
		return id_usuario;
	}

	public void setId_usuario(int id_usuario) {
		this.id_usuario = id_usuario;
	}

	public String getNome() {
		return nome;
	}

	public void setNome(String nome) {
		this.nome = nome;
	}

	public String getLogin() {
		return login;
	}

	public void setLogin(String login) {
		this.login = login;
	}

	public String getSenha() {
		return senha;
	}

	public void setSenha(String senha) {
		this.senha = senha;
	}

	public String getConfirmar() {
		return confirmar;
	}

	public void setConfirmar(String confirmar) {
		this.confirmar = confirmar;
	}

	public boolean isAdmin() {
		return admin;
	}

	public void setAdmin(boolean admin) {
		this.admin = admin;
	}

	public void init() {
		FacesContext context = FacesContext.getCurrentInstance();

		Object value = context.getExternalContext().getRequestParameterMap().get("id_usuario");

		if (value != null) {
			try {
				int val = Integer.parseInt(value.toString());

				usuarios u = data.getUsuario(val);

				if (u != null) {
					setId_usuario(u.getId_usuario());
					setNome(u.getNome());
					setLogin(u.getLogin());
					setAdmin(u.isAdmin());
				} else {
					context.addMessage(null,
							new FacesMessage(FacesMessage.SEVERITY_ERROR, "Register does not exist!", ""));
				}
			} catch (NumberFormatException ex) {
				context.addMessage(null, new FacesMessage(FacesMessage.SEVERITY_ERROR, "Invalid parameter!", ""));
			}
		}
	}

	public void inserir() {
		boolean ok = true;
		FacesContext context = FacesContext.getCurrentInstance();

		if (getNome() == null || getNome().isEmpty()) {
			ok = false;
			context.addMessage(null, new FacesMessage(FacesMessage.SEVERITY_ERROR, "Invalid name!", ""));
		}

		if (getLogin() == null || getLogin().isEmpty()) {
			ok = false;
			context.addMessage(null, new FacesMessage(FacesMessage.SEVERITY_ERROR, "Invalid username!", ""));
		}

		if (getSenha() == null || getSenha().isEmpty()) {
			ok = false;
			context.addMessage(null, new FacesMessage(FacesMessage.SEVERITY_ERROR, "Invalid password!", ""));
		}

		if (getConfirmar() == null || getConfirmar().isEmpty()) {
			ok = false;
			context.addMessage(null, new FacesMessage(FacesMessage.SEVERITY_ERROR, "Invalid password!", ""));
		} else if (!getSenha().equals(getConfirmar())) {
			ok = false;
			context.addMessage(null, new FacesMessage(FacesMessage.SEVERITY_ERROR, "Passwords do not match!", ""));
		}

		if (ok) {
			if (getId_usuario() == 0) {
				data.inserirUsuario(this);
				context.addMessage(null,
						new FacesMessage(FacesMessage.SEVERITY_INFO, "User inserted successfully!", ""));
			} else {
				data.atualizarUsuario(this);
				context.addMessage(null, new FacesMessage(FacesMessage.SEVERITY_INFO, "User updated sucessfully!", ""));
			}
		}
	}
}
