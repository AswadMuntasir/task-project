import React, { useState } from 'react';
import { Flex, Box, FormControl, FormLabel, Input, Button, Heading } from '@chakra-ui/react';
import axios from 'axios';
import { authenticateUser, logout } from '../auth/auth';

interface LoginPageProps {
  onSubmit: (username: string, password: string) => void;
}

const LoginPage: React.FC<LoginPageProps> = ({ onSubmit }) => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');

  const handleLogin = async () => {
    try {
      const token = await authenticateUser(username, password);

      // Store the JWT token in the user's local storage.
      localStorage.setItem('token', token);

      // Redirect the user to the main page.
      window.location.href = '/home';
    } catch (error) {
      // Display an error message to the user.
      console.error(error);
    }
  };

  const handleFormSubmit = (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    handleLogin();
  };

  const handleLogout = () => {
    logout();
  };

  return (
    <Flex align="center" justify="center" minH="100vh">
      <Box rounded="lg" bg="white" p={8} shadow="lg">
        <Heading fontSize="4xl" textAlign="center">
          Login
        </Heading>
        <form onSubmit={handleFormSubmit}>
          <FormControl mt={4}>
            <FormLabel>Username:</FormLabel>
            <Input
              type="text"
              placeholder="Enter your username"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
            />
          </FormControl>
          <FormControl mt={4}>
            <FormLabel>Password:</FormLabel>
            <Input
              type="password"
              placeholder="Enter your password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </FormControl>
          <Button mt={4} colorScheme="teal" type="submit">
            Login
          </Button>
        </form>
        <Button mt={4} colorScheme="red" onClick={handleLogout}>
          Logout
        </Button>
      </Box>
    </Flex>
  );
};

export default LoginPage;