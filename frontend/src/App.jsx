import { useEffect, useState } from 'react';
import axios from 'axios';


const API_URL = `http://${window.location.hostname}:8080/api/usuarios.php`;
const vacio = { nombre: '', apePaterno: '', apeMaterno: '', user: '', password: '', estado: 1 };

export default function App() {
  const [usuarios, setUsuarios] = useState([]);
  const [form, setForm] = useState(vacio);
  const [editId, setEditId] = useState(null);
  const [mensaje, setMensaje] = useState('');

  const cargarUsuarios = async () => {
    try {
      const { data } = await axios.get(API_URL);
      setUsuarios(data);
    } catch (err) {
      setMensaje('Error al cargar usuarios: ' + err.message);
    }
  };

  useEffect(() => {
    cargarUsuarios();
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  };

  const limpiarForm = () => {
    setForm(vacio);
    setEditId(null);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      if (editId) {
        const payload = { ...form };
        if (!payload.password) delete payload.password; // no sobreescribir si está vacío
        await axios.put(`${API_URL}?id=${editId}`, payload);
        setMensaje('Usuario actualizado correctamente');
      } else {
        await axios.post(API_URL, form);
        setMensaje('Usuario registrado correctamente');
      }
      limpiarForm();
      cargarUsuarios();
    } catch (err) {
      setMensaje('Error: ' + (err.response?.data?.error || err.message));
    }
  };

  const handleEdit = (u) => {
    setForm({ ...u, password: '' });
    setEditId(u.id);
  };

  const handleDelete = async (id) => {
    if (!confirm('¿Eliminar este usuario?')) return;
    try {
      await axios.delete(`${API_URL}?id=${id}`);
      setMensaje('Usuario eliminado correctamente');
      cargarUsuarios();
    } catch (err) {
      setMensaje('Error al eliminar: ' + err.message);
    }
  };

  return (
    <div style={{ maxWidth: 800, margin: '0 auto' }}>
      <h1>Gestión de Usuarios</h1>

      {mensaje && <p style={{ background: '#eef', padding: '0.5rem' }}>{mensaje}</p>}

      <form onSubmit={handleSubmit} style={{ display: 'grid', gap: '0.5rem', marginBottom: '2rem' }}>
        <input name="nombre" placeholder="Nombre" value={form.nombre} onChange={handleChange} required />
        <input name="apePaterno" placeholder="Apellido Paterno" value={form.apePaterno} onChange={handleChange} required />
        <input name="apeMaterno" placeholder="Apellido Materno" value={form.apeMaterno} onChange={handleChange} required />
        <input name="user" placeholder="Usuario" value={form.user} onChange={handleChange} required />
        <input
          name="password"
          type="password"
          placeholder={editId ? 'Nueva contraseña (opcional)' : 'Contraseña'}
          value={form.password}
          onChange={handleChange}
          required={!editId}
        />
        <select name="estado" value={form.estado} onChange={handleChange}>
          <option value={1}>Activo</option>
          <option value={0}>Inactivo</option>
        </select>
        <div>
          <button type="submit">{editId ? 'Actualizar' : 'Registrar'}</button>
          {editId && <button type="button" onClick={limpiarForm} style={{ marginLeft: '0.5rem' }}>Cancelar</button>}
        </div>
      </form>

      <table border="1" cellPadding="8" style={{ width: '100%', borderCollapse: 'collapse' }}>
        <thead>
          <tr>
            <th>ID</th><th>Nombre</th><th>Ape. Paterno</th><th>Ape. Materno</th>
            <th>Usuario</th><th>Estado</th><th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          {usuarios.map((u) => (
            <tr key={u.id}>
              <td>{u.id}</td>
              <td>{u.nombre}</td>
              <td>{u.apePaterno}</td>
              <td>{u.apeMaterno}</td>
              <td>{u.user}</td>
              <td>{u.estado == 1 ? 'Activo' : 'Inactivo'}</td>
              <td>
                <button onClick={() => handleEdit(u)}>Editar</button>{' '}
                <button onClick={() => handleDelete(u.id)}>Eliminar</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
