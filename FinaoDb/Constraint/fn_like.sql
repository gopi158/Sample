ALTER TABLE `fn_like`
  ADD CONSTRAINT `fn_like_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `fn_users` (`userid`),
  ADD CONSTRAINT `fn_like_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `fn_users` (`userid`);
