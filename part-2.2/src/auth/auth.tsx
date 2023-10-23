import axios from 'axios';

export const authenticateUser = async (username: string, password: string) => {
  const response = await axios.post('/task-project/api/login.php', {
    username,
    password,
  });

  if (response.status === 200) {
    return response.data.token;
  } else {
    throw new Error('Invalid username or password.');
  }
};

export const logout = () => {
    // Remove the JWT token from the user's local storage.
    localStorage.removeItem('token');
  
    // Redirect the user to the login page.
    window.location.href = '/login';
  };