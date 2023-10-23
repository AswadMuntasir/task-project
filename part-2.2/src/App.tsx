import React from 'react';
import LoginPage from './components/LoginPage';

function App() {
  const onSubmit = (username: string, password: string) => {
    // TODO: Implement authentication logic here
  };

  return (
    <LoginPage onSubmit={onSubmit} />
  );
}

export default App;