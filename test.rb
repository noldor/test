def checker(value)
  return 'FizzBuzz' if (value % 5).zero? && (value % 3).zero?

  return 'Buzz' if (value % 5).zero?

  return 'Fizz' if (value % 3).zero?

  value
end



(1..100).each do |element|
  puts checker(element)
end